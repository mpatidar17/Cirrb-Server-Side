<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Mail;

class CustomCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing Cron Job';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Mail::send('emails.paymentSuccess', [], function($message) {
         $message->to('hussainyuvasoft185@gmail.com','')->subject
            ('Cron Working');
         //$message->from('khallaf@3webbox.com','Khallaf');
         $message->from('info@3webbox.com','Cirrb');
        });
        
        /*$msg = "My name is Hussain";
        
        mail("hussainyuvasoft185@gmail.com","My subject",$msg);*/
    }
}