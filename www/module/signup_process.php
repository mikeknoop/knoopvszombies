  <div id="signup_process_title">
  Signup <span class="accent_color">Process</span>
  </div><!-- signup_title -->
  
  <ol>
  <li <?php if (isset($_GET['step'])) { if ($_GET['step'] == 1) { echo "class=\"process_highlight\""; } } else { echo "class=\"process_highlight\""; } ?>>Create an account</li>
  <li <?php if (isset($_GET['step'])) { if ($_GET['step'] == 2) { echo "class=\"process_highlight\""; } }?>>Confirm email</li>
  <li <?php if (isset($_GET['step'])) { if ($_GET['step'] == 3) { echo "class=\"process_highlight\""; } }?>>Code of conduct</li>
  <li <?php if (isset($_GET['step'])) { if ($_GET['step'] == 4) { echo "class=\"process_highlight\""; } }?>>Liability waiver</li>
  <li <?php if (isset($_GET['step'])) { if ($_GET['step'] == 5) { echo "class=\"process_highlight\""; } }?>>Profile information</li>
  <li <?php if (isset($_GET['step'])) { if ($_GET['step'] == 6) { echo "class=\"process_highlight\""; } }?>>Done!</li>
  </ol>
  