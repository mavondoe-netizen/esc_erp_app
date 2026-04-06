<?php
declare(strict_types=1);

namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Navigation cell
 */
class NavigationCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array<string, mixed>
     */
    protected array $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
         $modules = $this->fetchTable('Modules')
            ->find()
            ->where(['is_active'=>1])
            ->all();

        $this->set(compact('modules'));
    }
    
}
