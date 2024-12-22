<h3 class="text-center text-success">Ekipet</h3>

<table id="ekipTable" class="table table-bordered mt-5 display">
  <thead class="bg-info">
    <tr>
      <th>Ekip.NO</th>
      <th>Ekip Name</th>
      <th>Ekip Liga</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody class="bg-secondary text-light">
    <?php
    $number = 0;

    // Modify the query to join 'ekip' and 'liga' tables
    $select_ekip = "
      SELECT e.ekip_id, e.ekip_name, l.liga_name 
      FROM `ekip` e 
      JOIN `liga` l ON e.liga_id = l.liga_id
    ";
    $result = mysqli_query($con, $select_ekip);

    while ($row = mysqli_fetch_assoc($result)) {
        $ekip_id = $row['ekip_id'];
        $ekip_name = $row['ekip_name'];
        $liga_name = $row['liga_name']; // Fetch the liga name
        $number++;
    ?>
      <tr>
        <td><?php echo $number; ?></td>
        <td><?php echo $ekip_name; ?></td>
        <td><?php echo $liga_name; ?></td> <!-- Display liga name -->
        <td><a href="index.php?edit_ekip=<?php echo $ekip_id ?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
        <td><a href=""><i class="fa-solid fa-trash"></i></a></td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<!-- Initialize DataTable -->
<script>
  $(document).ready(function () {
    $('#ekipTable').DataTable({
      paging: true,
      searching: true,
      info: true,
      responsive: true,
      language: {
        search: "Search Ekip:",
        paginate: {
          first: "First",
          last: "Last",
          next: "Next",
          previous: "Previous"
        }
      }
    });
  });
</script>


