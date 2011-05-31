<?php if (!defined('APPLICATION')) exit(); ?>
<h1><?= T('Attach a poll'); ?></h1>
<h2>Create a poll question</h2>
    <div class="poll-field-input"> 
    <?= $this->Form->Open();?>
    <?= $this->Form->Label(T('Poll question'), 'Pollname');?>
    <div class="cleaner"></div>
    <?= $this->Form->TextBox('title');?>
    <div class="cleaner"></div>
    <br />
    <?= $this->Form->Button(T('Attach'));?>
    <?= $this->Form->Close();?>
    </div>
    <br />
    <?= T('The poll question will be attached to this discussion:')?> <b><? echo($this->Discussion->Name)?></b>