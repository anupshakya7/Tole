<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventsParticipants extends Model
{
    protected $table = 'events_participants';

    protected $fillable = ['event_id', 'participant_id', 'registered_at', 'donated_at', 'cert_received_at','blood_grp_card_received_at','previous_donation_at'];

    public function events()
    {
        return $this->belongsTo(Events::class,'event_id','id');
    }

    public function participants()
    {
        return $this->belongsTo(Participants::class,'participant_id','id');
    }
	
	public function user()
    {
        return $this->belongsTo(User::class);
    }
}
