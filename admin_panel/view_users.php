<?php

include 'main.php';

$users = Main::users();

include 'header.php';
?>
 <script type="text/javascript">
    $(document).ready(function() 
    {
      $('#user_table').DataTable({
        "paging":   true,
        "ordering": true,
        "info":     true,
        "order": [[ 0, "desc" ]]
        });
    } );
  </script>
  
    <div class="row">
      <div class="col-md-12">
        <div style="overflow-x:auto; padding:0 15px">
        <table class="table display" id="user_table" style="width:100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>User Email</th>
              <th>Join Date</th>
              <th>Last Login</th>
              <th>Days since last login</th>
              <th title=" 0 = Cronjob Enabled for the users,&#010 1 = Cronjob disabled for the users, &#010 59 = Inactive users list 60 days - Reminder Email sent to Admin, &#010 60 = Inactive user 60 days email sent to users, &#010 89 = Inactive users list 90 days - Deletion Ready Email sent to Admin, &#010 90 = Account Deletion Notice: Inactive user 90 days email sent to users, &#010 91 = User information deleted.">Counter (help ?)</th>
              <th>Cronjob</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>

          <?php
            if($users->num_rows > 0)
            {
              while($user = $users->fetch_assoc())
              {
                $start = strtotime($user['last_login']);
                $end = strtotime(date('Y-m-d'));
                $reminder = ceil(abs($end - $start) / 86400);
          ?>
            <tr>
              <td><?php echo $user['ID']; ?></td>
              <td><?php echo $user['display_name']; ?></td>
              <td><?php echo $user['user_email']; ?></td>
              <td><?php echo $user['user_registered']; ?></td>
              <td><?php echo $user['last_login']; ?></td>
              <td style="text-align:center"><?php echo $user['last_login'] ? $reminder : ''; ?></td>
              <td style="text-align:center"><?php echo $user['cronjob']; ?></td>
              <td>
              <input type="checkbox" <?php echo $user['cronjob'] != 1? 'checked':''; ?>>
                </td>
              <td id="<?php echo $user['ID']; ?>">
              <button class="save" onclick="save(this)">Save</button>
              </td>
            </tr>
          <?php
            }
          }
          ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>

<?php
include 'footer.php';
?>

  
<script>

function save(e)
{
  var reminder_set = 0;
  var elm1 = e.parentNode;
  var elm2 = e.parentNode.previousElementSibling;

  if(!elm2.firstChild.nextSibling.checked)
  {
    reminder_set = 1;
  }
    jQuery.ajax({
    type: "POST",
    data: {
      uid: elm1.getAttribute('id'),
      cronjob: reminder_set
    },
    url: "/wp-content/themes/veggie-lite-child/admin_panel/user_logins_update.php",
    dataType: "html",
    async: false,
    success: function(data)
    {
      elm2.previousElementSibling.innerHTML = reminder_set;
      // alert('The account remove from cron job action');
      if(data.length > 0)
      {
        console.log(data);
        result = JSON.parse(data);
        elm2.previousElementSibling.previousElementSibling.innerHTML = result.counter;
        elm2.previousElementSibling.previousElementSibling.previousElementSibling.innerHTML = result.last_login;
      }
    }
  });

}
</script>