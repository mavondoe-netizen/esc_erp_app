<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class SyncContactsToSuppliersCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $io->out('Starting synchronization of Contacts to Suppliers...');

        $Contacts = $this->fetchTable('Contacts');
        $Suppliers = $this->fetchTable('Suppliers');

        $contacts = $Contacts->find()->all();
        $count = 0;

        foreach ($contacts as $contact) {
            $supplier = $Suppliers->find()
                ->where([
                    'contact_id' => $contact->id,
                    'company_id' => $contact->company_id
                ])
                ->first();

            if (!$supplier) {
                $supplier = $Suppliers->newEmptyEntity();
                $supplier->contact_id = $contact->id;
                $supplier->company_id = $contact->company_id;
                $supplier->industry   = 'General';
                $io->out("Creating supplier for contact: {$contact->name}");
            } else {
                $io->out("Updating supplier for contact: {$contact->name}");
            }

            $supplier->name = $contact->name;
            $Suppliers->save($supplier);
            $count++;
        }

        $io->success("Done! Synchronized $count contacts.");
        return static::CODE_SUCCESS;
    }
}
