<?php
	$servername = "localhost";
	$username = "sempris";
	$password = "q18111987q";
	$dbname = "sempris_9291_sempris";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	
	$conn->set_charset("utf8");
	$sql = "SELECT creation_date, data FROM civ_randomizer_passwords WHERE password = '" . $_GET["password"] . "'";
	$result = $conn->query($sql);
	$conn->close();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Случайный выбор наций в Civilization V</title>
		<link rel="stylesheet" href="randomizer.css"/>
		<script type="text/javascript" src="randomizer.js"></script>
	</head>
	<body>
		<div id="randomizer">
			<h1 class="text-center">Случайный выбор наций в Civilization V</h1>
			<!--
			<center>
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"/>
				<ins class="adsbygoogle"
			         style="display:inline-block;width:728px;height:90px"
			         data-ad-client="ca-pub-8973224963834416"
			         data-ad-slot="1468273740"/>
				<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
			</center>
			-->
			<div id="log"></div>
			<ul id="results">
			<?php
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$xml = simplexml_load_string($row["data"]) or die("Error: Cannot create object");
					$doc = $xml->documentElement;
					$pos = 0;
					foreach ($doc->xpath("//player") as $nations) {
						$pos += 1;
						echo "<li>Игрок " . $pos . " выбирает из: " . join(", ",  $nations->xpath("nation")) . "</li>";
					}
				}
			?>
			</ul>
			<form name="randomizer">
				<div class="form-group">
					<label>
						<span>Количество игроков:</span>
						<select name="players_num">
							<option value="1">1 игрок</option>
							<option value="2">2 игрока</option>
							<option value="3">3 игрока</option>
							<option value="4">4 игрока</option>
							<option value="5">5 игроков</option>
							<option value="6" selected="selected">6 игроков</option>
							<option value="7">7 игроков</option>
							<option value="8">8 игроков</option>
							<option value="9">9 игроков</option>
							<option value="10">10 игроков</option>
							<option value="11">11 игроков</option>
							<option value="12">12 игроков</option>
						</select>
					</label>
				</div>
				<div class="form-group">
					<label>
						<span>Количество наций:</span>
						<select name="civs_num">
							<option value="1">1 нация</option>
							<option value="2">2 нации</option>
							<option value="3" selected="selected">3 нации</option>
							<option value="4">4 нации</option>
							<option value="5">5 наций</option>
							<option value="6">6 наций</option>
							<option value="7">7 наций</option>
							<option value="8">8 наций</option>
							<option value="9">9 наций</option>
							<option value="10">10 наций</option>
						</select>
					</label>
				</div>
				<div class="form-group">
					<span>Быстрые баны:</span>
					<button type="button" data-ban="standard">Стандарт</button>
					<button type="button" data-ban="none">Снять баны</button>
					<button type="button" data-ban="all">Забанить все</button>
					<button type="button" data-ban="inverse">Инвертировать</button>
				</div>
				<ul>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Австрия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/1_Austria.png" height="40" width="40"/>
							<span>Австрия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Америка" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/2_America.png" height="40" width="40"/>
							<span>Америка</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Англия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/3_England.png" height="40" width="40"/>
							<span>Англия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Аравия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/4_Arabia.png" height="40" width="40"/>
							<span>Аравия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Ассирия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/5_Assiria.png" height="40" width="40"/>
							<span>Ассирия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Ацтеки" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/6_Aztec.png" height="40" width="40"/>
							<span>Ацтеки</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Бразилия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/7_Brazil.png" height="40" width="40"/>
							<span>Бразилия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Вавилон" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/8_Babylon.png" height="40" width="40"/>
							<span>Вавилон</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Венеция" data-standard="false"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/9_Venice.png" height="40" width="40"/>
							<span>Венеция</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Византия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/10_Byzantium.png" height="40" width="40"/>
							<span>Византия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Германия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/11_Germany.png" height="40" width="40"/>
							<span>Германия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Голландия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/29_Holland.png" height="40" width="40"/>
							<span>Голландия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Греция" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/12_Greece.png" height="40" width="40"/>
							<span>Греция</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Гунны" data-standard="false" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/13_Hunns.png" height="40" width="40"/>
							<span>Гунны</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Дания" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/14_Denmark.png" height="40" width="40"/>
							<span>Дания</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Египет" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/15_Egypt.png" height="40" width="40"/>
							<span>Египет</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Зулусы" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/16_Zulu.png" height="40" width="40"/>
							<span>Зулусы</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Индия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/17_India.png" height="40" width="40"/>
							<span>Индия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Индонезия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/18_Indonesia.png" height="40" width="40"/>
							<span>Индонезия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Инки" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/19_Inca.png" height="40" width="40"/>
							<span>Инки</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Ирокезы" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/20_Iroquos.png" height="40" width="40"/>
							<span>Ирокезы</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Испания" data-standard="false" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/21_Spain.png" height="40" width="40"/>
							<span>Испания</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Карфаген" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/22_Carthage.png" height="40" width="40"/>
							<span>Карфаген</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Кельты" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/23_Celts.png" height="40" width="40"/>
							<span>Кельты</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Китай" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/24_China.png" height="40" width="40"/>
							<span>Китай</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Корея" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/25_Korea.png" height="40" width="40"/>
							<span>Корея</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Майя" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/26_Maya.png" height="40" width="40"/>
							<span>Майя</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Марокко" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/27_Morocco.png" height="40" width="40"/>
							<span>Марокко</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Монголия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/28_Mongolia.png" height="40" width="40"/>
							<span>Монголия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Персия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/30_Persia.png" height="40" width="40"/>
							<span>Персия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Полинезия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/31_Polynesia.png" height="40" width="40"/>
							<span>Полинезия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Польша" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/32_Poland.png" height="40" width="40"/>
							<span>Польша</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Португалия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/33_Portugal.png" height="40" width="40"/>
							<span>Португалия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Рим" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/34_Rome.png" height="40" width="40"/>
							<span>Рим</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Россия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/35_Russia.png" height="40" width="40"/>
							<span>Россия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Сиам" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/36_Siam.png" height="40" width="40"/>
							<span>Сиам</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Сонгай" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/37_Songhai.png" height="40" width="40"/>
							<span>Сонгай</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Турция" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/38_Turkey.png" height="40" width="40"/>
							<span>Турция</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Франция" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/39_France.png" height="40" width="40"/>
							<span>Франция</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Швеция" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/40_Sweden.png" height="40" width="40"/>
							<span>Швеция</span>
						</label>
					</li>
					<li>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Шошоны" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/41_Shoshone.png" height="40" width="40"/>
							<span>Шошоны</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Эфиопия" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/42_Efiopia.png" height="40" width="40"/>
							<span>Эфиопия</span>
						</label>
					</li>
					<li>
						<label>
							<input type="checkbox" name="allowed_civs[]" value="Япония" checked="true"/>
							<img src="http://sempris.od.ua/wp-content/civ_images/43_Japan.png" height="40" width="40"/>
							<span>Япония</span>
						</label>
					</li>
				</ul>
				<div class="form-group">
					<label>
						<h4 class="text-center">Разрешить дублирование наций
							<input type="checkbox" name="allow_duplicate_civs"/>
						</h4>
					</label>
				</div>
				<div class="text-center">
					<input name="password"/>
					<button type="submit">
						<font size="4">
							<b>Создать игру</b>
						</font>
					</button>
				</div>
				<!--
				<div class="text-center">
					<br/>
					<br/>
					<p>
						<a href="http://steamcommunity.com/groups/civ5freegame" target="_blank">
							<img src="/civ/Steam-logo.png" title="группа Steam" alt"группа Steam" width="50" height="50"/>
						</a>
						<font size="3"> &ndash; группа Steam для игроков в Civilization V</font>
					</p>
					<p>
						<a href="https://www.youtube.com/user/sempris2008/" target="_blank">
							<img src="/civ/Youtube-logo.png" title="YouTube-канал" alt"YouTube-канал" width="50" height="50"/>
						</a>
						<font size="3"> &ndash; YouTube-канал: записи игр в Civilization V</font>
					</p>
				</div>
				-->
			</form>
		</div>
	</body>
</html>