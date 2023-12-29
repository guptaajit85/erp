<?php
foreach ($drivers as $driverV) {
?>
  <option value="<?php echo $driverV->driver_id; ?>" <?php echo in_array($driverV->driver_id, $driver) ? 'selected' : ''; ?>><?= $driverV->driver_name . ' - ' . $driverV->driver_phone; ?></option>
<?php
}
?>
<select name="driver[]" title="Drivers"  multiple  data-actions-box="true"  data-style="bg-white rounded-pill px-4 py-3 shadow-sm " class="form-control input-sm  selectpicker w-100" data-selected-text-format="count"  >