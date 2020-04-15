<?php
video_conferencing_zoom_api_show_like_popup();

//Check if any transient by name is available
$users = video_conferencing_zoom_api_get_user_transients();
$zoom_map_array = get_option( 'zoom_api_meeting_options', array() );

if ( !isset( $_GET['host_id'] ) ) {
    $host_id = $users[0]->id;
} else {
    $host_id = $_GET['host_id'];
}

$encoded_meetings = zoom_conference()->listMeetings( $host_id );
$decoded_meetings = json_decode( $encoded_meetings );
$meetings         = $decoded_meetings->meetings;

if( isset( $_POST['end_meeting'] ) ) {
    $zoom_map_array[ esc_html( $_POST['end_meeting'] ) ][ 'ended' ] = 1;
    update_option( 'zoom_api_meeting_options', $zoom_map_array);
}
if( isset( $_POST['resume_meeting'] ) ) {
    unset( $zoom_map_array[ esc_html( $_POST['resume_meeting'] ) ][ 'ended' ] );
    update_option( 'zoom_api_meeting_options', $zoom_map_array);
}
?>
<div id="zvc-cover" style="display: none;"></div>
<div class="wrap">
    <h2><?php _e( "Meetings", "video-conferencing-with-zoom-api" ); ?></h2>
    <!--For Errors while deleteing this user-->
    <div id="message" style="display:none;" class="notice notice-error show_on_meeting_delete_error"><p></p></div>
	<?php if ( ! empty( $error ) ) { ?>
        <div id="message" class="notice notice-error"><p><?php echo $error; ?></p></div>
	<?php } else {
		?>
        <div class="select_zvc_user_listings_wrapp">
            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-top" class="screen-reader-text"><?php _e( "Select bulk action", "video-conferencing-with-zoom-api" ); ?></label>
                <select name="action" id="bulk-action-selector-top">
                    <option value="trash"><?php _e( "Move to Trash", "video-conferencing-with-zoom-api" ); ?></option>
                </select>
                <input type="submit" id="bulk_delete_meeting_listings" data-hostid="<?php echo $_GET['host_id']; ?>" class="button action" value="Apply">
				<?php if ( isset( $_GET['host_id'] ) ) { ?>
                    <a href="?page=zoom-video-conferencing-add-meeting&host_id=<?php echo $_GET['host_id']; ?>" class="button action" title="Add new meeting">Add New Meeting</a>
				<?php } ?>
            </div>
            <div class="alignright">
                <select onchange="location = this.value;" class="zvc-hacking-select">
                    <option value="?page=zoom-video-conferencing"><?php _e( 'Select a User', 'video-conferencing-with-zoom-api' ); ?></option>
					<?php foreach ( $users as $user ) { ?>
                        <option value="?page=zoom-video-conferencing&host_id=<?php echo $user->id; ?>" <?php echo $host_id == $user->id ? 'selected' : false; ?>><?php echo $user->first_name . ' ( ' . $user->email . ' )'; ?></option>
					<?php } ?>
                </select>
            </div>
            <div class="clear"></div>
        </div>

        <div class="zvc_listing_table">
            <table id="zvc_meetings_list_table" class="display" width="100%">
                <thead>
                <tr>
                    <th class="zvc-text-center"><input type="checkbox" id="checkall"/></th>
                    <th class="zvc-text-left"><?php _e( 'Meeting ID', 'video-conferencing-with-zoom-api' ); ?></th>
                    <th class="zvc-text-left"><?php _e( 'Topic', 'video-conferencing-with-zoom-api' ); ?></th>
                    <th class="zvc-text-left"><?php _e( 'Status', 'video-conferencing-with-zoom-api' ); ?></th>
                    <th class="zvc-text-left" class="zvc-text-left"><?php _e( 'Start Time', 'video-conferencing-with-zoom-api' ); ?></th>
                    <th class="zvc-text-left"><?php _e( 'End/Resume Meeting', 'video-conferencing-with-zoom-api' ); ?></th>
                    <th class="zvc-text-left"><?php _e( 'Created On', 'video-conferencing-with-zoom-api' ); ?></th>
                </tr>
                </thead>
                <tbody>
				<?php
				if ( ! empty( $meetings ) ) {
					foreach ( $meetings as $meeting ) {
                        ?>
                        <input type="hidden" name="host_ids" value="<?php echo esc_attr( $meeting->host_id )?>"/>
                        <tr>
                            <td class="zvc-text-center"><input type="checkbox" name="meetings_id[]" class="checkthis" value="<?php echo $meeting->id; ?>"/></td>
                            <td><span><?php echo $meeting->id; ?></span></td>
                            <td>
                                <a href="admin.php?page=zoom-video-conferencing-add-meeting&edit=<?php echo $meeting->id; ?>&host_id=<?php echo $meeting->host_id; ?>"><?php echo $meeting->topic; ?></a>
                                <div class="row-actions">
                                    <div class="trash"><a href="javascript:void(0);" data-meetingid="<?php echo $meeting->id; ?>"  data-hostid="<?php echo $meeting->host_id; ?>" class="submitdelete delete-meeting"><?php _e( 'Trash', 'video-conferencing-with-zoom-api' ); ?></a></div>
                                </div>
                            </td>
                            <td><?php
								if ( ! empty( $meeting->status ) ) {
									switch ( $meeting->status ) {
										case 0;
											echo '<img src="' . ZOOM_VIDEO_CONFERENCE_PLUGIN_ADMIN_IMAGES_PATH . '/2.png" style="width:14px;" title="Not Started" alt="Not Started">';
											break;
										case 1;
											echo '<img src="' . ZOOM_VIDEO_CONFERENCE_PLUGIN_ADMIN_IMAGES_PATH . '/3.png" style="width:14px;" title="Completed" alt="Completed">';
											break;
										case 2;
											echo '<img src="' . ZOOM_VIDEO_CONFERENCE_PLUGIN_ADMIN_IMAGES_PATH . '/1.png" style="width:14px;" title="Currently Live" alt="Live">';
											break;
										default;
											break;
									}
								} else {
									echo "N/A";
								}
								?>
                            </td>
                            <td><?php
	                            $timezone = !empty($meeting->timezone) ? $meeting->timezone : "America/Los_Angeles";
	                            $tz = new DateTimeZone($timezone);
	                            $date = new DateTime($meeting->start_time);
	                            $date->setTimezone($tz);
	                            echo $date->format('F j, Y, g:i a ( e )');
                                ?></td>
                            <td>
                                <form method="post" action="<?php echo admin_url() . 'admin.php?'. $_SERVER['QUERY_STRING']; ?>">
                                <?php if( !isset( $zoom_map_array[ $meeting->id ][ 'ended' ] ) ): ?>
                                    <button type="submit" name="end_meeting" value="<?php echo $meeting->id ?>">
                                        <?php _e( 'End Meeting', 'video-conferencing-with-zoom-api' ); ?>
                                    </button>
                                <?php endif; ?>
                                <?php if( isset( $zoom_map_array[ $meeting->id ][ 'ended' ] ) ): ?>
                                    <button type="submit" name="resume_meeting" value="<?php echo $meeting->id ?>">
                                        <?php _e( 'Resume Meeting', 'video-conferencing-with-zoom-api' ); ?>
                                    </button>
                                <?php endif; ?>
                                </form>
                            </td>
                            <td><?php
                            $timezone = !empty($meeting->timezone) ? $meeting->timezone : "America/Los_Angeles";
                            $tz = new DateTimeZone($timezone);
                            $date = new DateTime($meeting->created_at);
                            $date->setTimezone($tz);
                            echo $date->format('F j, Y, g:i a ( e )');
                            ?></td>
                        </tr>
						<?php
					}
				} ?>
                </tbody>
            </table>
        </div>
	<?php } ?>
</div>
