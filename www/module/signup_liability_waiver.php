<div id="signup_title">
  Sign up <span class="accent_color">sign our liability waiver</span>
  </div>

  <?php if (isset($_GET['state'])): ?>
  <div id="signup_status">
    <?php
      switch ($_GET['state'])
      {      
        case 'incomplete':
          echo 'You must sign your name. Plesae enter your full name and try again.';
        break;
            
        case 'invalidname':
          echo 'The name you entered is invalid. Please try again.';
        break;
           
        case 'slowdown':
          echo 'Please wait a few minutes before requesting another confirmation email. Check your email and try again in about 5 minutes.';
        break;
          
        default:
          echo 'An unknown error occured. Please try again.';
        break;
      }
    ?>
  </div>
  <?php endif ?>
    
  <div class="signup_body_text">
    WAIVER OF LIABILITY AND HOLD HARMLESS AGREEMENT<br />
    STUDENT-SPONSORED "HUMANS vs. ZOMBIES" GAME
  </div>

  <div class="signup_body_text">
  1 . In consideration for receiving permission from the University of Missouri administration to participate in the student-
  sponsored Humans vs. Zombies game during the fall semester 2009, I hereby RELEASE, WAIVE, DISCHARGE,
  AND COVENANT NOT TO SUE MU, the Board of Trustees of the University, its officers, agents, and employees
  thereinafter referred to as RELEASEES) from any and all liability, claims, demands, actions, and causes of action
  whatsoever arising out of or related to any loss, damage, or injury, including death, that I may sustain, or to any
  property that I own, while participating in such activity, or while in, on or upon the premises of the University or while
  off the campus. This release includes any losses caused or alleged to be caused, in whole or in part, by the negligence
  of RELEASEES to the fullest extent allowed by law (but not for gross negligence or willful or wanton conduct) and
  includes liability arising out of tort, contract, strict liability, or otherwise.
  </div>

  <div class="signup_body_text">
  2. I am fully aware of the risks and hazards connected with the game of Humans vs. Zombies, which include the risk of
  injury and even death, and I hereby elect to voluntarily participate in the game, knowing that the activity may be
  hazardous to me and my property. I understand that MU does not require me to participate in this activity or sponsor
  the activity but is permitting this activity to occur on the MU premises. I voluntarily assume full responsibility for any
  risks of loss, property damage, or personal injury, including death, that I may sustain, or any loss or damage to
  property that I own, as a result of being engaged in such activity. It is impossible to know and list every risk associated
  with the game, but the risks I may encounter include, but are not limited to: slipping, falling, or tripping; improper or
  malfunctioning equipment, and physical contact with other participants who may participate with me.
  </div>

  <div class="signup_body_text">
  3. I agree to abide by the “Responsibilities of Players of Humans vs. Zombies” (“Responsibilities”) and acknowledge that
  I am subject to MU’s Code of Conduct while participating in the game, either on or off-campus and that the College
  reserves the right to impose discipline and sanctions for any activities that occur during the course of the game that
  violate the Code of Conduct.
  </div>

  <div class="signup_body_text">
  4. I further hereby AGREE TO INDEMNIFY AND HOLD HARMLESS the RELEASEES from any loss, liability,
  damage, or costs, including court costs and attorneys’ fees, that they may incur due to my participation or the
  participation of one of my guests in the game. This includes loss, liability, damage or costs that occur to me, to other
  game participants or to third parties, including other Columbia community members or visitors to the campus. This
  agreement to indemnify includes loss, liability, damage or costs, including courts costs and attorneys’ fees, caused in
  whole or in part by the negligence of RELEASEES, to the fullest extent allowed by law (but not for gross negligence
  or willful or wanton conduct of RELEASEES).
  </div>

  <div class="signup_body_text">
  5. It is my express intent that this Waiver and Hold Harmless Agreement shall bind the members of my family and
  spouse, if I am alive, and my heirs, assigns and personal representative, if I am deceased, and shall be deemed as a
  RELEASE, WAIVER, DISCHARGE, AND COVENANT NOT TO SUE the above-named RELEASEES. I hereby
  further agree that this Waiver of Liability and Hold Harmless Agreement shall be construed in accordance with the
  laws of the State of Missouri and that any mediation, suit, or other proceeding regarding the activity of Humans vs.
  Zombies must be filed or entered into only in Missouri and the federal or state courts of Missouri. Any portion of this
  document deemed unlawful or unenforceable is severable and shall be stricken without any effect on the enforceability
  of the remaining provisions.
  </div>

  <div class="signup_body_text">
  IN SIGNING THIS RELEASE, I ACKNOWLEDGE AND REPRESENT THAT I have read the foregoing
  Waiver of Liability and Hold Harmless Agreement, understand it and sign it voluntarily as my own free act and
  deed; no oral representations, statements, or inducements, apart from the foregoing written agreement, have been
  made; I am at least eighteen (18) years of age and fully competent; and I execute this Release for full, adequate
  and complete consideration fully intending to be bound by same.
  </div>

  <div id="signup_waiver_agree_container">

  <div id="signup_waiver_agree_text">
  In WITNESS WHEREOF, I have signed this Waiver and Agreement on this<br /><span class="accent_color"><?php echo date("d"); ?></span>
  day of <span class="accent_color"><?php echo date("F"); ?></span>, <span class="accent_color"><?php echo date("Y"); ?></span>.
  </div>
  
  <div class="clearfix"></div>

  <form id="signup_form" name="signup" action="http://<?php echo DOMAIN; ?>/signup/4/submit" method="POST">
  
    <div class="signup_row_container">
      <div class="signup_row_label">
        Type Full Name
      </div>
      <div class="signup_row_textbox">
        <input id="waiver_name" name="waiver_name" type="textbox" class="signup_textbox" />
      </div>
      <div class="clearfix"></div>
    </div>

    <div id="signup_submit_container">
      <div id="signup_submit_label">
      </div>
      <div id="signup_submit_button">
        <input type="submit" class="signup_button" value="Submit" />
      </div>
      <div class="clearfix"></div>
    </div>
    
  </form>
  
  <div class="clearfix"></div>
</div>