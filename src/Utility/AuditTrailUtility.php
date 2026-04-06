<?php
namespace App\Utility;
use Cake\ORM\TableRegistry;
use Cake\Http\Session;
class AuditTrailUtility{
public static function log($entityType, $entityId, $action, $description, $userId=null){
$auditsTable = TableRegistry::getTableLocator()->get('AuditTrails');
$session =  new Session();
$userId = $userId ?? $session->read("Authentication.id");
$audit= $auditsTable->newEntity([
    'entity_type' => $entityType,
    'entity_id'=> $entityId,
    'action'=> $action,
    'description'=> $description,
    'user_id'=> $userId,
    'created'=> date('Y-m-d H:i:s')
]);
}

}