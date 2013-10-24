<?php if (!defined('APPLICATION')) exit();
/*

*/
class PollModule extends Gdn_Module {
   
   protected $_PollData;
   protected $_PollAnswers;
   protected $_PollVotes;
   protected $_PollCanVote;
   protected $_PollAlreadyVoted;
   protected $_PollCanManage;
   private $ID;
   
   public function __construct(&$Sender = '') {
      $this->_UserData = FALSE;
      parent::__construct($Sender);
   }

      public function DiscussionsController_Poll_Create($Sender)
      {
      
      }

   
   function GetData()
   {
   $SQL = Gdn::SQL();
   $id=$this->ID;
   
   
    
    $this->_PollData = $SQL->Select('t.*')->From('Poll t')->Where('discussion_id', $id)->Get()->FirstRow();

        
    if (!empty($this->_PollData))
    {
   
    $poll_id=$this->_PollData->id;
    
    $this->_PollAnswers = $SQL->Select('t.*')->From('PollAnswers t')->Where('poll_id', $poll_id)->OrderBy('id', 'asc')->Get();
   
    foreach ($this->_PollAnswers->Result() as $Answer)
    {
    
    $this->_PollVotes+=$Answer->votes;
        
    }
   
    }
   
   #
   
   
   }
   
   function SetID($ID)
   {
   
   $this->ID=$ID;
   
   }
   
   
   

   public function AssetTarget() {
      return 'Panel';
   }

   public function ToString() {
     
     $Session = Gdn::Session();
    
    
    
     
      $String = '';
      ob_start();
      ?>
      <div class="Box">
      <h4><?= T('Poll')?></h4> 
       
       
       <?if (!empty($this->_PollData)):?>
       <br />
       <h5><?= stripslashes($this->_PollData->title)?></h5>
       <ul class="poll-answers">
       <? foreach ($this->_PollAnswers->Result() as $Answer):?>
       <? $Percentage =  floor(($Answer->votes / $this->_PollVotes) * 100)?>
       <li class="answer-block">
       <?= Anchor(stripslashes($Answer->title), 'vanilla/discussion/poll/'.$this->_PollData->id.'/vote/'.$Answer->id)?>
       <br />
       <div class="poll-bar" style="width:<?= floor(($Answer->votes / $this->_PollVotes) * 100) + 1?>%;"></div> <span class="poll-percentage"><?= $Percentage?>% </span><span class="poll-numvotes">(<?= $Answer->votes?> votes)</span>
       <br />
       </li>
       <?endforeach?>
       </ul>
       <br />
       
        <?if($Session->CheckPermission('Plugins.Poll.Manage')):?>   
       <ul class="poll-options-list">
      <li><?= Anchor(T('Edit poll'), 'vanilla/discussion/editpoll/'.$this->_PollData->id, 'Reset poll')?></li><li><?= Anchor(T('Reset poll'), 'vanilla/discussion/poll/'.$this->_PollData->id.'/reset', 'Reset poll')?></li><li><?= Anchor(T('Delete poll'), 'vanilla/discussion/poll/'.$this->_PollData->id.'/delete', 'Delete poll')?></li>
       </ul>
       <?endif?>
        <?else:?>
        <?if($Session->CheckPermission('Plugins.Poll.Manage')):?>        
           <ul class="poll-options-list">
        <li><?= Anchor(T('Attach a poll'), 'vanilla/discussion/attachpoll/'.$this->ID, 'Attach a poll')?></li>
       </ul>
        <?else:?>
        <?= T('No poll attached to this discussion.') ?>
        <?endif?>
        <?endif?>
      </div>
      <?php
      $String = ob_get_contents();
      @ob_end_clean();
      return $String;
   }
}