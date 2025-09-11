<?php

require_once __DIR__.'/../repository/TaskRepository.php';

class PermissionChecker {
    
    public static function getUserRoleForTask($userId, $taskId) {
        $taskRepository = new TaskRepository();
        return $taskRepository->getUserRoleForTask($userId, $taskId);
    }
    
    public static function canViewTask($userId, $taskId) {
        $role = self::getUserRoleForTask($userId, $taskId);
        return in_array($role, ['Owner', 'Assigned', 'Viewer']);
    }
    
    public static function canEditTask($userId, $taskId) {
        $role = self::getUserRoleForTask($userId, $taskId);
        return in_array($role, ['Owner', 'Assigned']);
    }
    
    public static function canDeleteTask($userId, $taskId) {
        $role = self::getUserRoleForTask($userId, $taskId);
        return $role === 'Owner';
    }
    
    public static function requirePermission($permissionType, $userId, $taskId) {
        $hasPermission = false;
        
        switch ($permissionType) {
            case 'view_task':
                $hasPermission = self::canViewTask($userId, $taskId);
                break;
            case 'edit_task':
                $hasPermission = self::canEditTask($userId, $taskId);
                break;
            case 'delete_task':
                $hasPermission = self::canDeleteTask($userId, $taskId);
                break;
            default:
                $hasPermission = false;
        }
        
        if (!$hasPermission) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/tasks?message=You do not have permission to perform this action.");
            exit();
        }
    }
    
    public static function getUserPermissions($userId, $taskId) {
        $role = self::getUserRoleForTask($userId, $taskId);
        
        return [
            'role' => $role,
            'canView' => self::canViewTask($userId, $taskId),
            'canEdit' => self::canEditTask($userId, $taskId),
            'canDelete' => self::canDeleteTask($userId, $taskId)
        ];
    }
}
