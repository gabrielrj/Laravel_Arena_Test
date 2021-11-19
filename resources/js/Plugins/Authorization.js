export const Permissions = {
    'ALLPERMISSIONS': 'ALLPERMISSIONS',
    'VIEWPERMISSION': 'VIEWPERMISSION',
    'CREATEPERMISSION': 'CREATEPERMISSION',
    'EDITPERMISSION': 'EDITPERMISSION',
    'DELETEPERMISSION': 'DELETEPERMISSION',
}

export default function hasPermission(user_permissions, func_permission){
    return (_.find(user_permissions, (perm) => {
        return perm.value === 'ALLPERMISSIONS' || perm.value === func_permission
    }) != null)
}

