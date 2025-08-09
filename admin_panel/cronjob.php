<?php
include 'main.php';
include 'header.php';
?>
 <script type="text/javascript">
    $(document).ready(function() 
    {
      $('#user_table').DataTable({
        "paging":   true,
        "ordering": true,
        "info":     true,
        "order": [[ 0, "asc" ]]
        });
    } );
  </script>
<div class="row">
  <div class="col-md-12">
    <div class="col-md-12">
        <strong style="font-size:20px">Cronjob Setting</strong>
    </div>
    <div class="col-md-12">
      <div style="overflow-x:auto; padding:0 15px">
        <table class="table display" id="user_table" style="width:100%">
        <thead>
          <tr>
            <th># ID</th>
            <th>Cronjob Name</th>
            <th>Action For</th>
            <th>Applied At</th>
            <th style="width:50px">Enable/Disable</th>
            <th style="width:50px">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // var_dump($main->cronjob()->fetch_assoc());
          // exit;
          $result = $main->cronjob();
          if($result->num_rows > 0)
          {
            while( $data = $result->fetch_assoc() )
            {
              ?>
              <tr>
                <td><?php echo $data['id']; ?></td>
                <td><?php echo $data['name']; ?></td>
                <td><?php echo $data['action_for']; ?></td>
                <td date="<?php echo date('Y-m-d H:i:s'); ?>"><?php echo $data['updated_at']; ?></td>
                <td status="<?php echo $data['status']; ?>" style="color:<?php echo $data['status'] == 1? 'green':'red';?>"><?php echo $data['status'] == 1? 'Enabled':'Disabled';?></td>
                <td id="<?php echo $data['id']; ?>"><button type="button" onclick="Edit(this)">Edit</button></td>
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
</div>
<?php
include 'footer.php';
?>
<script>

  /** edit method */
  function Edit(e)
  {
    var elm1 = e.parentNode;
    var elm2 = elm1.previousElementSibling;
    var elm3 = elm2.previousElementSibling;
    var elm4 = elm3.previousElementSibling;
    var elm5 = elm4.previousElementSibling;
    /** add input field */
    elm5.innerHTML = '<input name="name" value="'+elm5.innerHTML+'" style="width:100%;padding:5px">';

    var status = 0;
    var checked = '';
    if(elm2.getAttribute('status') == 1)
    {
      status = 1;
      checked = 'checked';
    }

    /** add status check input field */
    elm2.innerHTML = '<input type="checkbox" name="status" value="'+status+'" '+checked+'>';

    /** replace by save button */
    elm1.innerHTML = '<button type="button" onclick="Save(this)">Save</button>';
  }

  /** save method */
  function Save(e)
  {
    var elm1 = e.parentNode;
    var elm2 = elm1.previousElementSibling;
    var elm3 = elm2.previousElementSibling;
    var elm4 = elm3.previousElementSibling;
    var elm5 = elm4.previousElementSibling;

    /** cronjob name value */
    var name = elm5.firstChild.value

    /** cronjob status value */
    var status = 0;
    var status_name = 'Disabled';
      elm2.style.color = 'red';
    if(elm2.firstChild.checked)
    {
      status = 1;
      status_name = 'Enabled';
      elm2.style.color = 'green';
    }

    /** get cronjob id */
    var id = elm1.getAttribute('id');

    /** submit data to database for update by ajax */
    jQuery.ajax({
      type: "POST",
      data: {
        id: id,
        name: name,
        status: status
      },
      url: "/wp-content/themes/veggie-lite-child/admin_panel/cronjob_update_ajax.php",
      dataType: "html",
      async: false,
      success: function(data)
      {
        //
      }
    });

    /** replace status name enable/disabled */
    elm2.innerHTML = status_name;

    /** set attribute */
    elm2.setAttribute('status', status);

    /** replace by current date */
    elm3.innerHTML = elm3.getAttribute('date');

    /** replace by edited name */
    elm5.innerHTML = name;

    /** replace by save button */
    elm1.innerHTML = '<button type="button" onclick="Edit(this)">Edit</button>';
  }
</script>