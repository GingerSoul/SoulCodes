// SoulCodes Scripts

(function ($, top, navigator) {
	/**
	 * Centralizes clipboard operations.
	 *
	 * @param {navigator} nav
	 * @param {window} top
	 *
	 * @constructor
	 */
	var Clipboard = function (nav, top) {
		this.nav = nav;
		this.top = top;

		this._init = function () {

		};

		this.setContents = function (text) {
			this._validateFeature();
			this.nav.clipboard.writeText(text);
		};

		this.getContents = function () {
			this._validateFeature();
			this.nav.clipboard.readText();
		};

		this._validateFeature = function () {
			if (!this.nav.clipboard) {
				if (!this.top.isSecureContext) {
					throw new Error('Clipboard access is denied because context is unsecure.');
				}

				throw new Error('Clipboard is not available');
			}
		};

		this._init.bind(this);
		this._validateFeature.bind(this);
		this.setContents.bind(this);
		this.getContents.bind(this);

		this._init()
	};

	/**
	 * A component that represents a shortcode details box.
	 *
	 * @param {HTMLElement} el
	 * @param {Clipboard} clipboard
	 *
	 * @constructor
	 */
	var ShortcodeBox = function (el, clipboard) {
		/** @var navigator */
		this.clipboard = clipboard;
		this.el = el;
		this.$el = $(this.el);

		this._init = function() {
			var self = this;
			this.$el.on('click', '.button-copy-to-clipboard', function () {
				self._copyShortcodeToClipboard();
			});
		};

		this.getShortcode = function () {
			return this._getShortcodeInput().val();
		};

		this._getShortcodeInput = function () {
			return this.$el.find('input[name="name"]');
		};

		this._copyShortcodeToClipboard = function () {
			var shortcode = this.getShortcode();
			this._copyToClipboard('[' + shortcode + ']');
		};

		this._copyToClipboard = function (text) {
			this.clipboard.setContents(text);
		};

		this._init.bind(this);
		this.getShortcode.bind(this);
		this._getShortcodeInput.bind(this);
		this._copyShortcodeToClipboard.bind(this);
		this._copyToClipboard.bind(this);

		this._init();
	};

	/**
	 * The SoulCodes admin panel client-side application.
	 *
	 * @constructor
	 */
	var Application = function () {
		this.clipboard = null;
		this.components = [];

		this.init = function () {
			self = this;
			this.clipboard = new Clipboard(navigator, top);

			$('.user-shortcode-box').each(function () {
				var box = new ShortcodeBox(this, self.clipboard);
				self.components.push(box);
			});
		};

		this.init.bind(this);
	};

	$(function () {
		var app = new Application();
		app.init();
	});
}(jQuery, window, navigator));
