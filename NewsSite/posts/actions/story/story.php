<?php
// story class for ease of use

class Story {
    public $id, $creatorId, $title, $body, $link, $created, $authorUname, $vote_count;
    function __construct($id, $creatorId, $title, $body, $link, $created, $authorUname=null, $vote_count=0) {
        $this->id = $id;
        $this->creatorId = $creatorId;
        $this->title = $title;
        $this->body = $body;
        $this->link = $link;
        $this->created = $created;
        $this->authorUname = $authorUname;
        $this->vote_count = $vote_count;
    }
    function printout(){
        printf("<p>*%s*[%s], id: %s</p>", $this->title, $this->body, $this->id);
    }
};
?>
