<?php if (!defined('APPLICATION')) exit(); ?>
<h1><?= T('Edit a poll'); ?></h1>
    <div class="poll-field-input"> 
    <?= $this->Form->Open();?>
    <?= $this->Form->Label(T('Poll question'), 'Pollname');?>
    <div class="cleaner"></div>
    <?= $this->Form->TextBox('title',array('value'=>$this->Poll->title));?>
    <div class="cleaner"></div>
    <br />
    <h2>Answers</h2>
    <?$i=0;?>
    <? foreach ($this->Answers->Result() as $answer):?>
    <?$i++?>
    <?= $this->Form->Label(T('Answer #').$i);?>
    <div class="cleaner"></div>
    <?= $this->Form->TextBox('edit_answer_'.$answer->id,array('value'=>stripslashes($answer->title)));?> <?= Anchor(T('Delete'),'discussion/editpoll/'.$this->Poll->id.'/deleteanswer/'.$answer->id)?>
    <div class="cleaner"></div>
    
        
    
    <?endforeach?>
    <?
    $res=$this->Answers->Result();
     if (empty($res)):?><?= T('No answers yet')?><?endif?>
    
    <div class="cleaner"></div>
    <br />
    
    <?= $this->Form->Label(T('Add a new answer'));?>
    <div class="cleaner"></div>
    <?= $this->Form->TextBox('new_answer');?>
    <div class="cleaner"></div>
    <br />
    <?= $this->Form->Button(T('Edit'));?>
    <?= $this->Form->Close();?>
    </div>
    <br />
    <b><? echo (Anchor(T("Back to the discussion"),"discussion/".$this->Poll->discussion_id))?></b>