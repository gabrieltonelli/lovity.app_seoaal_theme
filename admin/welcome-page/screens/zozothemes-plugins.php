<?php
$zozo_theme = wp_get_theme();
if($zozo_theme->parent_theme) {
    $template_dir =  basename( get_template_directory() );
    $zozo_theme = wp_get_theme($template_dir);
}
$zozo_theme_version = $zozo_theme->get( 'Version' );
$zozo_theme_name = $zozo_theme->get('Name');
$plugins = TGM_Plugin_Activation::$instance->plugins;
$installed_plugins = get_plugins();
$active_action = '';
if( isset( $_GET['plugin_status'] ) ) {
	$active_action = $_GET['plugin_status'];
}
$tgm_obj = new Seoaal_Zozo_Admin_Page();
?>
<div class="wrap about-wrap welcome-wrap zozothemes-wrap">
	<h1 class="hide" style="display:none;"></h1>
	<div class="zozothemes-welcome-inner">
		<div class="welcome-wrap">
			<h1><?php echo esc_html__( "Welcome to", "seoaal" ) . ' ' . '<span>'. $zozo_theme_name .'</span>'; ?></h1>
			<div class="theme-logo"><span class="theme-version"><?php echo esc_attr( $zozo_theme_version ); ?></span></div>
			
			<div class="about-text"><?php echo esc_html__( "Nice!", "seoaal" ) . ' ' . $zozo_theme_name . ' ' . esc_html__( "is now installed and ready to use. Get ready to build your site with more powerful WordPress theme. We hope you enjoy using it.", "seoaal" ); ?></div>
		</div>
		<h2 class="zozo-nav-tab-wrapper nav-tab-wrapper">
			<?php
			printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=seoaal' ),  esc_html__( "Support", "seoaal" ) );
			printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=seoaal-demos' ), esc_html__( "Install Demos", "seoaal" ) );
			printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', esc_html__( "Plugins", "seoaal" ) );
			printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=system-status' ), esc_html__( "System Status", "seoaal" ) );
			?>
		</h2>
	</div>
		
	<div class="zozothemes-required-notices">
		<p class="notice-description"><?php echo esc_html__( "These are the plugins we recommended for Seoaal. Currently Zozothemes Core, Visual Composer are required plugins that is needed to use in Seoaal. You can activate, deactivate or update the plugins from this tab.", "seoaal" ); ?></p>
	</div>
	
	<div class="zozothemes-plugin-action-notices">
		<?php $plugin_deactivated = '';
		if( isset( $_GET['zozo-deactivate'] ) && $_GET['zozo-deactivate'] == 'deactivate-plugin' ) {
			$plugin_deactivated = $_GET['plugin_name']; ?>		
			<?php printf( '<p class="plugin-action-notices deactivate">%1$s, %2$s <strong>%3$s</strong>.', esc_attr( $plugin_deactivated ), esc_html('plugin', 'seoaal'), esc_html('deactivated.', 'seoaal') );
		} ?>
		<?php $plugin_activated = '';
		if( isset( $_GET['zozo-activate'] ) && $_GET['zozo-activate'] == 'activate-plugin' ) {
			$plugin_activated = $_GET['plugin_name']; ?>	
			<?php printf( '<p class="plugin-action-notices activate">%1$s, %2$s <strong>%3$s</strong>.', esc_attr( $plugin_activated ), esc_html('plugin', 'seoaal'), esc_html('activated.', 'seoaal') );	
		} ?>
	</div>
	
	<div class="zozothemes-demo-wrapper zozothemes-install-plugins">
		<div class="feature-section theme-browser rendered">
			<?php
			foreach( $plugins as $plugin ):
				$class = '';
				$plugin_status = '';
				$active_action_class = '';
				$file_path = $plugin['file_path'];
				$plugin_action = $tgm_obj->seoaal_plugin_link( $plugin );
				foreach( $plugin_action as $action => $value ) {
					if( $active_action == $action ) {
						$active_action_class = ' plugin-' .$active_action. '';
					}
				}
				
				$is_plug_act = 'is_plugin_active';
				if( $is_plug_act( $file_path ) ) {
					$plugin_status = 'active';
					$class = 'active';
				}
			?>			
			<div class="theme <?php echo esc_attr( $class . $active_action_class ); ?>">
				<div class="install-plugin-inner">
					<div class="theme-screenshot">
						<img src="<?php echo esc_url( $plugin['image_url'] ); ?>" alt="<?php esc_attr( $plugin['name'] ); ?>" />
					</div>
					<h3 class="theme-name">
						<?php
						if( $plugin_status == 'active' ) {
							echo sprintf( '<span>%s</span> ', esc_html__( 'Active:', 'seoaal' ) );
						}
						echo esc_html( $plugin['name'] );
						?>
					</h3>
					<div class="theme-actions">
						<?php foreach( $plugin_action as $action ) { echo ( ''. $action ); } ?>
					</div>
					<?php if( isset( $plugin_action['update'] ) && $plugin_action['update'] ): ?>
					<div class="theme-update"><?php echo esc_html__('Update Available: Version', 'seoaal'); ?> <?php echo esc_attr( $plugin['version'] ); ?></div>
					<?php endif; ?>
	
					<?php if( isset( $installed_plugins[$plugin['file_path']] ) ): ?> 
					<div class="plugin-info">
						<?php echo sprintf('Version %s | %s', $installed_plugins[$plugin['file_path']]['Version'], $installed_plugins[$plugin['file_path']]['Author'] ); ?>
					</div>
					<?php endif; ?>
					<?php if( $plugin['required'] ): ?>
					<div class="plugin-required">
						<?php esc_html_e( 'Required', 'seoaal' ); ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	
	<div class="zozothemes-thanks">
        <hr />
    	<p class="description"><?php echo esc_html__( "Thank you for choosing", "seoaal" ) . ' ' . $zozo_theme_name . '.'; ?></p>
    </div>
</div>