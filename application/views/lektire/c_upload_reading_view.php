<p>
	Ukoliko imate kvalitetnu i dobru lektiru podijelite to sa drugima. Pomozite nam da povećamo zbirku lektira i tako pomognemo novim generacijama.
</p>

<p>
	Dozvoljene ekstenzije datoteka su: doc, zip, rar. Molimo vas da u zip ili rar datoteke stavljajte .doc ili srodne datoteke.
</p>

<?=  $this->form_validation->set_error_delimiters('<b>', '</b>'); ?>
<div id="kontakt">
		<form action="<?=base_url();?>lektire/upload" method="post" class="generic-form" id="upload-form" name="upload-form" enctype="multipart/form-data">
			<h2>Pošaljite lektiru</h2>
			<p style="color: red; font-size: 1em;">
			</p>

			<fieldset>
				<p>
					<label for="reading_title" title="Upišite naziv lektire">Naziv lektire: <em>(Obavezno)</em></label><br />
					<?= form_error('reading_title'); ?>
					<input name="reading_title" id="reading_title" tabindex="4" type="text" value="<?= set_value("reading_title") ? set_value("reading_title") : "" ?>"/>
				</p>
				<p>
					<label for="reading_author"  title="Upišite pisca lektire">Pisac lektire: <em>(Obavezno)</em></label><br />
					<?= form_error('reading_author'); ?>
					<input name="reading_author" id="reading_author" tabindex="5" type="text" value="<?= set_value("reading_author") ? set_value("reading_author") : "" ?>"/>
				</p>
				<p>
					<label for="uploader_full_name"  title="Upišite vaše puno ime">Vaše ime i prezime: <em>(Obavezno)</em></label><br />
					<?= form_error('uploader_full_name'); ?>
					<input name="uploader_full_name" id="uploader_full_name" tabindex="6" type="text" value="<?= set_value("uploader_full_name") ? set_value("uploader_full_name") : "" ?>"/>
				</p>
				<p>
					<label for="uploader_email"  title="Upišite vašu email adresu">Email adresa: <em>(Obavezno)</em></label><br />
					<?= form_error('uploader_email'); ?>
					<input name="uploader_email" id="uploader_email" tabindex="7" type="text" value="<?= set_value("uploader_email") ? set_value("uploader_email") : "" ?>"/>
				</p>
				<p>
					<label for="uploader_website"  title="Upišite vašu web adresu">Web adresa (npr. Facebook profil): </label><br />
					<?= form_error('uploader_website'); ?>
					<input name="uploader_website" id="uploader_website" tabindex="8" type="text" value="<?= set_value("uploader_website") ? set_value("uploader_website") : "http://" ?>"/>
				</p>
				<p>
					<label for="uploader_info"  title="Upišite podatke o školi koju pohađate">Razred i škola: (npr. 5 razred, OŠ A.G. Matoš) </label><br />
					<?= form_error('uploader_info'); ?>
					<input name="uploader_info" id="uploader_info" tabindex="9" type="text" value="<?= set_value("uploader_info") ? set_value("uploader_info") : "" ?>"/>
				</p>
				<p>
					<label for="reading_file"  title="Staza do datoteke sa lektirom">Datoteka sa lektirom: <em>(Obavezno)</em></label><br />
					<?= form_error('reading_file'); ?>
					<input name="reading_file" type="file" tabindex="10" size="80"/><br />
					<small>Dozvoljene ekstenzije datoteka su: doc, zip, rar.</small>
					<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
				</p>

			</fieldset>

			<fieldset id="formControls">
			<input type="hidden" name="submit" value="submit" />
			<input name="submitBtn" id="submitBtn" tabindex="9"  type="image" src="<?= static_url("img/tipka_posalji.jpg"); ?>" alt="Submit" />
			</fieldset>
		</form>
</div> <!-- END - kontakt -->
<div class="clear"></div>