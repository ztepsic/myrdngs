<p>
	Za bilo kakve upite, prijedloge, prijave neispravnih lektiri ili pohvale iskoristite kontakt formu.
</p>
<p>
	Molimo Vas da poruke budu kratke, jednostavne i smislene. Obično Vam možemo odgovoriti unutar 24 sata od primitka poruke. Molimo Vas da ne zlouporabite kontakt forumu. Jamčimo Vam privatnost podataka poslanih putem kontakt forme.
</p>

<?=  $this->form_validation->set_error_delimiters('<b>', '</b>'); ?>
<div id="kontakt">
		<form action="<?=site_url("informacije/kontakt");?>" method="post" class="generic-form" id="contact-form" name="contact-form">
			<h2>Pošaljite nam upit</h2>
			<p style="color: red; font-size: 1em;">
			</p>

			<fieldset>
				<p>
					<label for="naslov" title="Upišite naslov poruke">Naslov: <em>(Obavezno)</em></label><br />
					<?= form_error('contact_subject'); ?>
					<input name="contact_subject" id="naslov" tabindex="4" type="text" value="<?= set_value("contact_subject") ? set_value("contact_subject") : "" ?>"/>
				</p>
				<p>
					<label for="poruka"  title="Poruka - budite što više detaljni">Poruka: <em>(Obavezno)</em></label><br />
					<?= form_error('contact_message'); ?>
					<textarea name="contact_message" cols="30" rows="5" id="poruka" tabindex="5"><?= set_value("contact_message") ? set_value("contact_message") : "" ?></textarea>
				</p>
				<p>
					<label for="ime"  title="Upišite vaše puno ime">Vaše ime: <em>(Obavezno)</em></label><br />
					<?= form_error('contact_name'); ?>
					<input name="contact_name" id="ime" tabindex="6" type="text" value="<?= set_value("contact_name") ? set_value("contact_name") : "" ?>"/>
				</p>
				<p>
					<label for="emailAdresa"  title="Upišite vašu email adresu">Email adresa: <em>(Obavezno)</em></label><br />
					<?= form_error('contact_email'); ?>
					<input name="contact_email" id="emailAdresa" tabindex="7" type="text" value="<?= set_value("contact_email") ? set_value("contact_email") : "" ?>"/>
				</p>
			</fieldset>

			<fieldset id="formControls">
				<input type="hidden" name="submit" value="submit" />
				<input name="submitBtn" id="submitBtn" tabindex="8"  type="image" src="<?= static_url("img/tipka_posalji.jpg"); ?>" alt="Submit" />
			</fieldset>
		</form>
</div> <!-- END - kontakt -->
<div class="clear"></div>

