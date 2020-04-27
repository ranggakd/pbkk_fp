<?php

namespace Dengarin\Main\Models;

use App\Utils\ModelTraits\Timestamp;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple;

/**
 * Class User
 * @property Simple|UserData $data
 * @method  Simple|UserData     getData($parameters = null)
 * @method  integer             countData()
 */
class User extends Model
{
    use Timestamp;

    const ROLE_ADMIN = 'admin';
    const ROLE_SOUND = 'sound';
    const ROLE_AMPLIFIER = 'amplifier';
    const ROLE_GUEST = 'guest';

    const STATUS_DISABLED = 1;
    const STATUS_EMAIL_VERIFIED = 2;
    const STATUS_VERIFIED_ACCOUNT = 4;

    public $id;
    public $username;
    public $email;
    public $name;
    public $password;
    public $role;
    private $status;

    public function initialize()
    {
        $this->setSource('users');
        $this->hasOne('id', UserData::class, 'id', [
            'reusable' => true,
            'alias' => 'data'
        ]);
    }

    public function isStatus(int $statusCode): bool
    {
        return ($this->status & $statusCode) == $statusCode;
    }

    public function enableStatus(int $statusCode){
        if (!$this->isStatus($statusCode))
            $this->status ^= $statusCode;
    }

    public function disableStatus(int $statusCode){
        if ($this->isStatus($statusCode))
            $this->status ^= $statusCode;
    }
}