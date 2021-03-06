export const TextController = function(dependencies = {}) {
    const { httpServiceAyax } = dependencies;
    this.httpServiceAyax = httpServiceAyax;
    this.onInit();
    this.loadAddEvenListener();
    console.log('Controlador del texto');
};

TextController.prototype = Object.create(
    {},
    {
        onInit: {
            value: function() {
                this.gui = this.loadDomElements();
            },
        },

        loadDomElements: {
            value: () => ({
                addTextForm: window.document.getElementById('addTextForm'),
                editTextForm: window.document.querySelectorAll('.editTextForm'),
                deleteTextForm: window.document.querySelectorAll('.deleteForm'),
            }),
        },

        loadAddEvenListener: {
            value: function() {
                this.gui.addTextForm.addEventListener('submit', this.addSubmitAction.bind(this));

                const editNodesArray = Array.from(this.gui.editTextForm);
                editNodesArray.forEach(node => {
                    node.addEventListener('submit', this.editSubmitAction.bind(this));
                });

                const deleteNodesArray = Array.from(this.gui.deleteTextForm);
                deleteNodesArray.forEach(node => {
                    node.addEventListener('submit', this.deleteSubmitAction.bind(this));
                });
            },
        },

        mapFormDataToJson: {
            value: function(formData) {
                const object = {};
                formData.forEach(function(value, key) {
                    object[key] = value;
                });
                return JSON.stringify(object);
            },
        },

        deleteSubmitAction: {
            value: function(event) {
                event.preventDefault();
                const textForm = event.target;
                const url = textForm.action;
                const formData = new FormData(textForm);
                const jsonData = this.mapFormDataToJson(formData);
                this.httpServiceAyax
                    .delete(url, {
                        contextType: 'application/json',
                        data: jsonData,
                    })
                    .then(response => {
                        if (response.status === 'ok') {
                            window.location.reload(false);
                        }
                    });
            },
        },

        editSubmitAction: {
            value: function(event) {
                event.preventDefault();
                const textForm = event.target;
                const urlBase = window.location.origin;
                const urlTextForm = textForm.dataset.url;
                const url = urlBase + urlTextForm;
                const formData = new FormData(textForm);
                const jsonData = this.mapFormDataToJson(formData);

                this.httpServiceAyax
                    .post(url, {
                        contextType: 'application/json',
                        data: jsonData,
                    })
                    .then(response => {
                        if (response.status === 'ok') {
                            window.location.reload(false);
                        }
                    });
            },
        },

        addSubmitAction: {
            value: function(event) {
                event.preventDefault();
                const textForm = event.target;
                const urlBase = window.location.origin;
                const urlTextForm = textForm.dataset.url;
                const url = urlBase + urlTextForm;
                const formData = new FormData(textForm);
                const jsonData = this.mapFormDataToJson(formData);

                this.httpServiceAyax
                    .post(url, {
                        contextType: 'application/json',
                        data: jsonData,
                    })
                    .then(response => {
                        if (response.status === 'ok') {
                            window.location.reload(false);
                        }
                    });
            },
        },
    },
);
