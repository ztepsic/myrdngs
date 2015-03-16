<?php

/**
 * Sucelje koje je potrebno implementirati za Link proxy
 * @author Željko Tepšić
 * @version 1.0.0
 *
 */
interface ILinkProxy {
	/**
	 * Metoda koja generira Header
	 * @param $id - identifikator po zelji, interpretacija ovisi o implementaciji
	 */
	public function Header($id = 0);
}

?>