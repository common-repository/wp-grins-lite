<?php 
/* Admin Panel Code - Created on April 19, 2008 by Ronald Huereca 
Last modified on October 24, 2009
*/
if (empty($this->adminOptionsName)) { die(''); }

$options = $this->get_admin_options(); //global settings

//Check to see if a user can access the panel
if ( !current_user_can('administrator') )
	die('');

//Update settings
if (isset($_POST['update'])) { 
	check_admin_referer('wp-grins-lite_options');
	$options['manualinsert'] = $_POST['manual'];
	$this->adminOptions = $options;
	$this->save_admin_options();
	?>
	<div class="updated"><p><strong><?php _e('Settings successfully updated.', $this->localizationName) ?></strong></p></div>
	<?php
}
?>

<div class="wrap">
	 <h2>WP Grins Lite Options</h2>
  	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<?php wp_nonce_field('wp-grins-lite_options') ?>
   
    
    <table class="form-table">
      <tbody>
        <tr valign="top">
          <th scope="row"><?php _e('Manually insert grins? You will have to call wp_print_grins()', $this->localizationName) ?></th>
          <td><p><label for="manual_yes"><input type="radio" id="manual_yes" name="manual" value="true" <?php if ($options['manualinsert'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes',$this->localizationName); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="manual_no"><input type="radio" id="manual_no" name="manual" value="false" <?php if ($options['manualinsert'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No',$this->localizationName); ?></label></p></td>
        </tr>
     </tbody>
    </table>
    <div class="submit">
      <input type="submit" name="update" value="<?php _e('Update Settings', $this->localizationName) ?>" />
    </div>
  </form>
</div><!--/wrap-->