<div class="gbtr_tools_wrapper">
    <div class="container_12">
            <div class="gbtr_tools_search">
                <form method="get" action="<?php echo home_url(); ?>">
                    <input class="gbtr_tools_search_inputtext" type="text" value="<?php echo esc_html($s, 1); ?>" name="s" id="s" />
                    <button type="submit" class="gbtr_tools_search_inputbutton"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div class="gbtr_tools_account">
                <ul>
                    <?php if ( has_nav_menu( 'tools' ) ) : ?>
                    <?php  
                    wp_nav_menu(array(
                        'theme_location' => 'tools',
                        'container' =>false,
                        'menu_class' => '',
                        'echo' => true,
                        'items_wrap'      => '%3$s',
                        'before' => '',
                        'after' => '',
                        'link_before' => '',
                        'link_after' => '',
                        'depth' => 0,
                        'fallback_cb' => false,
                    ));
                    ?>
                    <?php else: ?>
                        Define your top bar navigation.
                    <?php endif; ?>
					
					<?php
					$loginUrl = esc_url( get_permalink( get_page_by_title( 'Login' ) ) );
					$loginUrlWithRedirect = add_query_arg( 'loginredirect', get_permalink(), $loginUrl );
					?>
					<?php if(is_user_logged_in()): ?>
						<li id="menu-item-logout" class="menu-item"><a href="<?php echo wp_logout_url( home_url() ); ?>" title="Logout">Logout</a></li>
					<?php else: ?>
						<li id="menu-item-login" class="menu-item"><a href="<?php echo $loginUrlWithRedirect; ?>" title="Login">Login</a></li>
					<?php endif; ?>
                </ul>
            </div>      
    </div>
</div>