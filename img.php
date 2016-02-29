Requested Ressource: <pre><?php echo $_POST['u']; ?></pre> <br>
Resulting Job DESC: <pre><?php echo $job['job']; ?></pre> <br>
Resulting Job SIGN: <pre><?php echo $job['sig']; ?></pre> <br>

<?php $url = "/?a=r&u={$_POST['u']}&j={$job['job']}&s={$job['sig']}" ?>

Resulting URL: <pre><?php echo $url; ?></pre> <br>

<table>
  <tr>
    <td>
      <img src="<?php echo $_POST['u']; ?>">
      <br>
      original
    </td>
    <td>
      <img src="<?php echo $url; ?>">
      <br>
      result
    </td>
  </tr>
</table>
