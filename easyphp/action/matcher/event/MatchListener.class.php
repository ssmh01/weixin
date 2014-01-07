<?php

/**
 * This interface represents a event listenner to processing the match event.
 * @see <code>MatchEvent</code>
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-6
 */

 interface MatchListener{
 	
 	/**
 	 * This function will invoke before the invoke <code>ActionMatch::matchs</code>.
 	 * @param MatchEvent $event
 	 * @see <code>MatchEvent</code>
 	 */
 	public function beforeMatch(MatchEvent $event);
 	
 	/**
 	 * This function will been invoke when the <code>HttpRequest</code> is match the <code>ActionMampping</code>.
 	 * @param MatchEvent $event
 	 * @see <code>MatchEvent</code>
 	 */
 	public function isMatch(MatchEvent $event);
 }