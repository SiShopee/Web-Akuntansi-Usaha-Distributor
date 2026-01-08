<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table            = 'messages';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['sender_id', 'sender_name', 'target_role', 'message', 'is_read', 'created_at'];
}