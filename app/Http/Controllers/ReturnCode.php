<?php

namespace App\Http\Controllers;

class ReturnCode
{
    const RET_SUCCESS                           = 0;
    const RET_INVALID_ARGS                      = 1;
    const RET_PERMISSION_DENY                   = 2;
    const RET_USER_EXIST                        = 3;
    const RET_USER_NOT_EXIST                    = 4;
    const RET_ACTIVITY_EXIST                    = 5;
    const RET_ACTIVITY_NOT_EXIST                = 6;
    const RET_DATABASE_FAIL                     = 7;
    const RET_FAIL                              = 8;

    public static $Msg = array (
        0  => 'Success',
        1  => 'Invalid Arguments',
        2  => 'Permission deny',
        3  => 'User already exist',
        4  => 'User does not exist',
        5  => 'Activity already exist',
        6  => 'Activity does not exist',
        7  => 'Database fail',
        8  => 'Fail',
    );
}
