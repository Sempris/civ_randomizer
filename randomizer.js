/**
 * Create a new game
 * @constructor
 * @param {Object[]} civs - all existing civs
 * @param {number} playersNumber - player number
 * @param {number} civsNumber - number of civs to choose from
 */
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
			if (civs.length < this.civsNumber) {
				throw 'Cannot create the game. <br/> Choose less players or nations.';
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
		mapCivs(),
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
				game.civs =  mapCivs();
				break;
		}
	});
	
	form.addEventListener('click', function (e) {
		var ban = e.target.getAttribute('data-ban');
		if (ban) {
			game.civs = mapCivs(function (input) {
				switch (ban) {
					case 'none':
						input.checked = true;
						break;
					case 'inverse':
						input.checked = !input.checked;
						break;
					case 'standard':
						input.checked = input.getAttribute('data-standard') != 'false';
				}
			});
		}
	});
	
	form.addEventListener('submit', function (e) {
		try {
			var output = game.calc();
		}
		catch (e) {
			var error = e;
		}
		if (this.password && this.password.value) {
			// Make calculation, save to database
		}
		else {
			// Display results without page refresh
			e.preventDefault();
			render(output, error);
		}
	});
}

/**
 * Goes through all civs and returns each of them in form of an object with a name an a status
 * Through callback parameter the function could be called for each civ and gets the corresponding input
 * @param {Function} [callback]
 */
function mapCivs (callback) {
	return Array.prototype.map.call(
		document.forms['randomizer']['allowed_civs[]'],
		function (input) {
			if (typeof callback == 'function') callback(input);
			return {
				name: input.value,
				available: input.checked
			}
		}
	)
}

/**
 * Show the calculation result in the document
 * @param {Object[]} [output] - assigns civs for players
 * @param {string} [error] - error text
 */
function render (output, error) {
	var results = document.getElementById('results'),
		log = document.getElementById('log');
		
	results.innerHTML = '';
	log.innerHTML = '';
	
	if (output) {
		for (var i = 0; i < output.length; i++) {
			var li = document.createElement('li');
			li.innerHTML = '<span>Player ' + (i + 1) + '</span> chooses from: ' + output[i].join(' / ');
			results.appendChild(li);
		}
	}
	if (error) {
		var div = document.createElement('div');
		div.innerHTML = error;
		log.appendChild(div);
	}
}
