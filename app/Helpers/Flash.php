<?php 

class Flash {
    public readonly String $id;
    public String $title = "";
    public readonly String $message;
    public Bool $closable = True;
    public Int $delay = 5;
    public String $type = "success";
    public Bool $important = False;

    function __construct($msg) {
        $str=rand();
        $this->id = md5($str);
        $this->message = $msg;
    }

    public function success() {
        $this->type = "success";
        return $this;
    }

    public function warning() {
        $this->type = "warning";
        return $this;
    }

    public function error() {
        $this->type = "error";
        return $this;
    }

    public function info() {
        $this->type = "info";
        return $this;
    }

    public function important() {
        $this->important = True;
        return $this;
    }

    public function delay($val) {
        $this->delay = $val;
        return $this;
    }

    public function title($title) {
        $this->title = $title;
        return $this;
    }
}

function flash($msg) {
    $flash = new Flash($msg);
    $fMessages = (array) session()->get('fMessages', []);
    $fMessages[] = $flash;
    session()->put('fMessages', $fMessages);
    // dd($flash);
    return $flash;
}