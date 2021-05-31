function Game (civs, playersNumber, civsNumber) {
	this.playersNumber = playersNumber;
	this.civsNumber = civsNumber;
	this.civs = civs;
	this.allowDuplicates = false;
	
	this.calc = function () {
		var civs = this.civs.filter(function (civ) {
			return civ.available;
		});
		var result = [];
		for (var i = 0; i < this.playersNumber; i++) {
			if (civs.length < civsNumber) {
				throw 'Нельзя сотворить здесь! <br/> Выберите меньше игроков или наций.';
			}
			var plCivs = civs.map(function (civ) {
				return civ.name;
			});
			for (var j = 0; j < civs.length - this.civsNumber; j++) {
				var rnd = Math.floor(Math.random() * plCivs.length);
				plCivs = plCivs.filter(function (civ, pos) {
					return pos != rnd;
				});
			}
			result.push(plCivs);
			if (this.allowDuplicates == false) {
				civs = civs.filter(function (civ) {
					return plCivs.indexOf(civ.name) < 0;
				});
			}
		}
		return result;
	}
}

window.onload = function () {
	var form = document.forms['randomizer'];
	var game = new Game (
		Array.prototype.map.call(
			form['allowed_civs[]'],
			function (input) {
				return {
					name: input.value,
					available: input.checked
				}
			}
		),
		parseInt(form['players_num'].value),
		parseInt(form['civs_num'].value)
	);
	
	form.addEventListener('change', function (e) {
		switch (e.target.name) {
			case 'players_num':
				game.playersNumber = parseInt(e.target.value);
				break;
			case 'civs_num':
				game.civsNumber = parseInt(e.target.value);
				break;
			case 'allow_duplicate_civs':
				game.allowDuplicates = e.target.checked;
				break;
			case 'allowed_civs[]':
				game.civs.forEach(function (civ) {
					if (civ.name == e.target.value) {
						civ.available = e.target.checked;
					}
				});
		}
	});
	
	form.addEventListener('click', function (e) {
		var action = e.target.getAttribute('data-ban');
		if (action) {
			ban(action);
		}
	});
	
	form.addEventListener('submit', function (e) {
		e.preventDefault();
		log.clear();
		try {
			renderPlayersList(game.calc());
		}
		catch (e) {
			log.write(e);
		}
	});
}

function ban (action) {
	Array.prototype.map.call(
		document.forms['randomizer']['allowed_civs[]'],
		function (input) {
			switch (action) {
				/*case 'standart':
					(label.id == 'standart-ban') {input.checked = false;}
					break;*/
				case 'none':
					input.checked = true;
					break;
				case 'inverse':
					input.checked = !input.checked;
					break;
			}
		}
	)
}

function renderPlayersList (list) {
	var ul = document.getElementById('results');
		ul.innerHTML = '';
	
	for (var i = 0; i < list.length; i++) {
		var li = document.createElement('li');
		li.innerHTML = '<span>Игрок ' + (i + 1) + '</span> выбирает из: ' + list[i].join(' / ');
		ul.appendChild(li);
	}
}

var log = {
	write: function (text) {
		var div = document.createElement('div');
		div.innerHTML = text;
		document.getElementById('log').appendChild(div);
	},
	clear: function () {
		document.getElementById('log').innerHTML = '';
	}
}