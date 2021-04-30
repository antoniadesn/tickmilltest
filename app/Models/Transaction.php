<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class Transaction extends Model
{
    use HasFactory;

    protected $appends = ['client_name'];

    public function getClientNameAttribute()
    {
        if($this->client_id)
        {
            $client = Client::findOrFail($this->client_id);
            
            if($client)
                return $client->first_name.' '. $client->last_name;
        }

        return "";
    }
}
