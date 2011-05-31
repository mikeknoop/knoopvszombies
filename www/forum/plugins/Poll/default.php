<?php
// Define the plugin:

$PluginInfo['Poll'] = array(
   'Description' => 'Simple poll plugin.',
   'Version' => '0.9',
   'Author' => "Cereal",
   'AuthorEmail' => 'doj.cerealkiller@gmail.com ',
   'AuthorUrl' => 'http://www.orsys.cz',
   'RegisterPermissions' => array('Plugins.Poll.Manage','Plugins.Poll.View','Plugins.Poll.Delete'),

);


class Poll implements Gdn_IPlugin 

{

public $Uses = array('DiscussionModel');
public $ID;

   public function DiscussionController_Editpoll_Create(&$Sender) 
    {
      
      
      
      $Session = Gdn::Session();
      $Params=$Sender->RequestArgs;
      $poll_id=$Params[0];
      
        
      $SQL = Gdn::SQL();
      
      $poll = $SQL->Select('t.*')->From('Poll t')->Where('id', $poll_id)->Get()->FirstRow();
      
      if (empty($poll)) {   Redirect('./'); }
      
      if(!$Session->CheckPermission('Plugins.Poll.Manage'))
        {
          Redirect('discussion/'.$poll->discussion_id);         
        }
      
      
      $Sender->Poll=$poll;
      
      $answers = $SQL->Select('t.*')->From('PollAnswers t')->Where('poll_id', $poll_id)->OrderBy('id', 'asc')->Get();
      
      $Sender->Answers=$answers;
      
      
      if ($_POST)
      {
      
      
      $SQL->Update('Poll')->Set('title', $_POST['Form/title'])->Where('id', $poll_id)->Put();
        
      
      
      
      if (!empty($_POST['Form/new_answer']))
      {
      
      $answer_id=$SQL->Insert('PollAnswers',array('id'=>'','poll_id'=>$poll_id,'title'=>$_POST['Form/new_answer'],'votes'=>'0'));
      
      Redirect('discussion/editpoll/'.$poll_id);   
      
      
      }
      
      
      
      foreach ($_POST as $var=>$val)
      {
      
      
      
      if (strstr($var,"Form/edit_answer_"))
      {
      
      $answer_id=trim(substr($var,17,strlen($var)-17));
      
      
      $answer= $SQL->Select('t.*')->From('PollAnswers t')->Where('id', $answer_id)->Get()->FirstRow();
      
      if (!$answer || $answer->poll_id!=$poll_id)  Redirect('discussion/editpoll/'.$poll_id);
      else 
      {
      
      
        $SQL->Update('PollAnswers')->Set('title', $val)->Where('id', $answer->id)->Put();
         
      
      
      }
      
      
      
      }
      
      
      
      }
      Redirect('discussion/editpoll/'.$poll_id);
      
      
      
      
      }
      
      if ($Params[1]=='deleteanswer')
      {
      
      $answer= $SQL->Select('t.*')->From('PollAnswers t')->Where('id', $Params[2])->Get()->FirstRow();
      
      if (!$answer || $answer->poll_id!=$poll_id)  Redirect('discussion/editpoll/'.$poll_id);
      else 
      {
      
        $SQL->Delete('PollAnswers',array('id'=>$answer->id));
        Redirect('discussion/editpoll/'.$poll_id);  
      
      } 
      
      
      
      }
      
      $Sender->Render('plugins/Poll/views/edit.php');
      
    }

   
   public function DiscussionController_Attachpoll_Create(&$Sender) 
    {

      $Session = Gdn::Session();
      $Params=$Sender->RequestArgs;
      $discussion_id=$Params[0];
      $SQL = Gdn::SQL();
      
      
        if(!$Session->CheckPermission('Plugins.Poll.Manage'))
        {
          Redirect('discussion/'.$discussion_id);         
        }
      
      $Sender->DiscussionID=$discussion_id;
      
        $Discussion = $Sender->DiscussionModel->GetID($discussion_id);
         if (!$Discussion) 
         {
         
          Redirect('./');
         
         }
         else { $Sender->Discussion=$Discussion; }
          
          
        if ($_POST['Form/title'])
        {
        
        #echo $_POST['Form/title'];
        
        $poll_id=$SQL->Insert('Poll',array('id'=>'','discussion_id'=>$discussion_id,'title'=>$_POST['Form/title']));
        
        Redirect('discussion/editpoll/'.$poll_id);
         
        
        }
          
                
      $Sender->Render('plugins/Poll/views/attach.php');

    
    }
  
   
   function CanVote($user_id,$poll_id)
   {
    
    $Session = Gdn::Session();
    $SQL = Gdn::SQL();
     
    $poll = $SQL->Select('t.*')->From('PollRecords t')->Where('poll_id', $poll_id)->Where('user_id',$user_id)->Get()->FirstRow();

    if (empty($poll)) return true; else return false;
    
   
   }
   
   public function DiscussionController_Poll_Create(&$Sender) 
    {
    
      $Session = Gdn::Session();
    
     
    
    $Params=$Sender->RequestArgs;
    $poll_id=$Params[0];
    $action=$Params[1];
    $click=$Params[2];
    
    $SQL = Gdn::SQL();
    
    $poll = $SQL->Select('t.*')->From('Poll t')->Where('id', $poll_id)->Get()->FirstRow();
    
    $discussion_id=$poll->discussion_id;
    
    if (empty($poll)) { Redirect('./'); }
    
    switch ($action)
    {
      case "vote":
    
        if(!$Session->CheckPermission('Plugins.Poll.View'))
        {
         
         
          Redirect('discussion/'.$discussion_id);         
        }
        else 
        {
          
          $user_id= $Session->UserID;
          if ($this->CanVote($user_id,$poll_id)) {
          
          $answer = $SQL->Select('t.*')->From('PollAnswers t')->Where('id', $click)->Get()->FirstRow();
          $votes=$answer->votes;
          $votes+=1;
          $SQL->Update('PollAnswers')->Set('votes', $votes)->Where('id', $click)->Put();
          
          $SQL->Insert('PollRecords',array('id'=>'','poll_id'=>$poll_id,'user_id'=>$user_id));
          } else { Redirect('discussion/'.$discussion_id); }
        }
    
      break;
      case "reset":
        if(!$Session->CheckPermission('Plugins.Poll.Manage'))
        {
          Redirect('discussion/'.$discussion_id);         
        }
        else 
        {
        
          $answers = $SQL->Select('t.*')->From('PollAnswers t')->Where('poll_id', $poll_id)->Get();
          
          foreach ($answers->Result() as $answer)
          {
          
            $SQL->Update('PollAnswers')->Set('votes', 0)->Where('id', $answer->id)->Put();
          
          }

            $SQL->Delete('PollRecords',array('poll_id'=>$poll_id));

        }  

      break;
      case "delete":
        if(!$Session->CheckPermission('Plugins.Poll.Manage'))
          {
            Redirect('discussion/'.$discussion_id);   
          }
          else
          {
          
             $SQL->Delete('Poll',array('id'=>$poll_id));
             $SQL->Delete('PollAnswers',array('poll_id'=>$poll_id));
                  
          }
          
      break;  
    
    }
    
    
    
    
    
    
    
    
    
    
    
       
    
    #echo $discussion_id;
    Redirect('discussion/'.$discussion_id);
    
    }
   
   

    public function DiscussionController_BeforeDiscussionRender_Handler(&$Sender) 
    {
   
      $Sender->AddCSSFile('plugins/Poll/design/poll.css'); 
    
#    $Session = Gdn::Session();
       
    #echo $DiscussionID = GetValue('DiscussionID', $Sender->EventArguments, 0);
   # $Object = GetValue('Object', $Sender->EventArguments);
    
 #   $DiscussionID = GetValue('DiscussionID', $Sender->EventArguments, 0);
    
      
    
      
      #print_r($Sender->Discussion->DiscussionID);
    
      include_once(PATH_PLUGINS.DS.'Poll'.DS.'class.pollmodule.php');
      $PollModule = new PollModule($Sender);
      $PollModule->SetID($Sender->DiscussionID);
      $PollModule->GetData();
      $Sender->AddModule($PollModule);
      
      #die;
 #   $Sender->Options .= '<li>'.Anchor(T('Attach a poll'), 'vanilla/discussion/startpoll/'.$DiscussionID.'/'.$Session->TransientKey().'?Target='.urlencode($Sender->SelfUrl), 'StartPoll') . '</li>'; 

    }


    public function Setup()
    {
    
    $Construct = Gdn::Structure();


$Construct->Table('Poll')
	->PrimaryKey('id')
   ->Column('discussion_id', 'int', TRUE)
   ->Column('title', 'varchar(255)')
   ->Set($Explicit, $Drop);

$Construct->Table('PollAnswers')
	->PrimaryKey('id')
   ->Column('poll_id', 'int', TRUE)
   ->Column('title', 'varchar(255)')
   ->Column('votes', 'int')
   ->Set($Explicit, $Drop);


   $Construct->Table('PollRecords')
	->PrimaryKey('id')
   ->Column('poll_id', 'int', TRUE)
   ->Column('user_id', 'int')
   ->Set($Explicit, $Drop);



    }
    


}




?>