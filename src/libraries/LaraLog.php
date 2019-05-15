<?php


namespace FarshidRezaei\LaraLog\Libraries;


use Carbon\Carbon;
use FarshidRezaei\LaraLog\Models\LaraLogModel;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaraLog
{
    protected $level;
    protected $subject;
    protected $message;
    protected $has_user;
    protected $user_id;

    /**
     * @param      $level
     * @param      $message
     * @param bool $has_user
     *
     * @return LaraLog
     */
    public static function new()
    {
        return ( new static )->newLog();
    }

    /**
     * @param      $level
     * @param      $message
     * @param bool $has_user
     *
     * @return LaraLog
     */
    protected function newLog()
    {
        $this->level = 'info';
        $this->subject = '';
        $this->message = '';
        $this->has_user = false;
        $this->user_id = false;
        return $this;

    }

    /**
     * @param string $level
     *
     * @return $this
     */
    public function level( $level = 'info' )
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @param string $subject
     *
     * @return $this
     */
    public function subject( $subject = '' )
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function message( $message = '' )
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param bool $has_user
     *
     * @return $this
     */
    public function user( $has_user = true )
    {
        $this->has_user = $has_user;
        if ( $has_user ) $this->setUserId();
        return $this;
    }

    public function submit()
    {

        if ( $this->canAddLogToFile() ) {
            $log_line = $this->addLogToFile();
            if ( ! $this->canAddLogToDb() ) return $log_line;
        }

        if ( $this->canAddLogToDb() ) return $this->addLogToDb();


    }

    protected function isAjax()
    {
        return ( request()->ajax() );
    }

    protected function setUserId()
    {
        $this->user_id = $this->has_user ? Auth::guard( $this->isAjax() ? 'api' : 'web' )->id() : '';

    }

    /**
     * @param $level
     * @param $subject
     * @param $message
     * @param $user_id
     *
     * @return string
     */
    protected function createLogLine()
    {
        //log time
        $log_content = "[" . Carbon::now()->toTimeString() . "]";
        //log level
        $log_content .= " <" . $this->level . ">";
        //log subject
        $log_content .= $this->subject !== "" ? " {" . $this->subject . "}" : "";
        //log message
        $log_content .= " \"" . $this->message . "\"";
        //log user
        $log_content .= $this->user_id == ! false ? " (" . $this->user_id . ")" : "";

        return $log_content;
    }

    /**
     * @return bool
     */
    protected function isTodayLogFileExist()
    {
        return Storage::disk( 'local' )->exists( "LaraLog/" . Carbon::now()->toDateString() . ".log" );
    }

    /**
     *
     */
    protected function createTodayLogFile()
    {
        $today = Carbon::now();
        $log_header = "[" . $today->toDateString() . "]\n";
        Storage::disk( 'local' )
            ->put( "LaraLog/" . $today->toDateString() . ".log", $log_header );
    }

    /**
     * @param $log_line
     */
    protected function addLineToTodayLog( $log_line )
    {
        Storage::disk( 'local' )
            ->append( "LaraLog/" . Carbon::now()->toDateString() . ".log", $log_line );
    }

    /**
     * @return string
     */
    protected function addLogToFile()
    {
        if ( ! $this->isTodayLogFileExist() ) $this->createToDayLogFile();

        $new_line = $this->createLogLine();

        $this->addLineToTodayLog( $new_line );

        return $new_line;
    }

    /**
     * @return Repository|mixed
     */
    protected function canAddLogToDb()
    {
        return config( 'laralog.db_driver', false );
    }

    /**
     * @return Repository|mixed
     */
    protected function canAddLogToFile()
    {
        return config( 'laralog.file_driver', false );
    }

    /**
     * @return LaraLogModel
     */
    protected function addLogToDb()
    {
        $log = new LaraLogModel();
        $log->level = $this->level;
        $log->subject = $this->subject;
        $log->message = $this->message;
        $log->user_id = $this->user_id;
        $log->save();

        return $log;
    }
}