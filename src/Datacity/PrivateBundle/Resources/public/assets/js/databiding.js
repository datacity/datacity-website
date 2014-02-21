//	Objet DataBiding : contains a collection of buttonModel and is the interface to manage the databiding
var DataBiding = function() {
	this.buttonModelArray = [];
	this.init();
}

DataBiding.prototype = {	
	//	Add a new category in the container
	addCategory: function(value) {
		if (this.checkIfSameButtonName(value) == true)
			return;
		var button = new ButtonModel(value);
		this.buttonModelArray.push(button);
		$("#categoryModelContainer").append(button.htmlElement).append('<br/>');
	},
	checkIfSameButtonName: function(value) {
		for (var i in this.buttonModelArray) {
			if (this.buttonModelArray[i].value == value)
				return true;
		}
		return false;
	},
	getClickedButton: function() {
		for (var i in this.buttonModelArray) {
			if (this.buttonModelArray[i].isClicked == true)
				return this.buttonModelArray[i];
		}
		return false;
	},
	getButtonFromId: function(id) {
		for (var i in this.buttonModelArray) {
			if (this.buttonModelArray[i].id === id) {
				return this.buttonModelArray[i];
			}
		}
		return false;
	},
	getButtonFromValue: function(value) {
		for (var i in this.buttonModelArray) {
			if (this.buttonModelArray[i].value === value) {
				return this.buttonModelArray[i];
			}
		}
		return false;
	},
	getButtonFromColor: function(color) {
		for (var i in this.buttonModelArray) {
			if (this.buttonModelArray[i].color === color) {
				return this.buttonModelArray[i];
			}
		}
		return false;
	},
	getRemoteCategories: function(callback) {
		//TODO: Partie sécurité donc soit passer par un service php qui se charge d'envoyer les bonnes routes de sécurité
		// Ou sinon extraire la clé privée depuis le client en js (me paraît un peu plus crade)
		// En attendant, clé en dur

		var parameters = {
			publickey: "4561321edgjlkjd",
			category: "services_publics"
		}
		$.ajax({
			url: "http://localhost:4567/source/model",
			type: 'GET',
			data: parameters,
			success: function(response, textStatus, jqXHR) {
				if (response.data)
					callback(response.data);
			},
			error: function(err) {
				console.error(err);
				callback(err);
			}
		});	
	},
	//	Get the value from the input html autocomplete
	getInputCategory: function() {
		return $("#inputModel").val();
	},
	setColorIndicator: function(color) {
		$('.boxColored').css('background-color', color);
	},
	setDesactivatePreviousClicked: function() {
		var clickedButton = this.getClickedButton();
		if (clickedButton === false)
			return;
		clickedButton.setIsClicked(false);
	},
	clickedButtonInterface: function(button) {
		if (button.isClicked === false)
			this.setDesactivatePreviousClicked();
		button.setClickStatus();
		this.setColorIndicator('white');
		if (button && button.isClicked === true)
			this.setColorIndicator(button.color);
	},
	init: function() {
		var that = this;
		//We load first the categories from remote server and in the callback we will ensure that 
		//the categories are loaded
		this.getRemoteCategories(function(categories) {
			if (categories instanceof Array) {
				$('#inputModel').autocomplete({
					delay: 0,
					source: categories
				});
			}
			that.initEvents();
		});
	},
	initEvents: function() {
		var that = this;

		var onAddCategory = function() {
			$('#addCategoryModel').on('click', function() {
				var inputCategory = that.getInputCategory();
				if (inputCategory) {
					that.addCategory(inputCategory);
					$('#inputModel').val("");
				}
			});
		}();
		
		var onClickEnter = function() {
			$('#inputModel').on('keypress', function(e) {
				if (e.which == 13) {
					var inputCategory = that.getInputCategory();
					if (inputCategory) {
						that.addCategory(inputCategory);
						$('#inputModel').val("");
					}
				}
			});
		}();
		
		var onClickCategory = function() {
			$('#categoryModelContainer').on('click', 'button', function(e) {
				var id = $(this).attr('id');
				that.clickedButtonInterface(that.getButtonFromId(id));
			});
		}();
	}
}

//	Element of DataBiding
var ButtonModel = function(value) {
	this.color = getRandomColor();
	this.id = getRandomId();
	this.value = value;
	this.isClicked = false;
	this.htmlElement = $(document.createElement('button'))
	.css('background-color', this.color)
	.css('color', 'white')
	.text(this.value.toUpperCase())
	.attr('id', this.id)
	.attr('class', 'btn btnmodel');
}

ButtonModel.prototype = {
	setClickStatus: function() {
		this.isClicked = !this.isClicked;
	},
	setIsClicked: function(status) {
		this.isClicked = status;
	}
}