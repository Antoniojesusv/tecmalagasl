export const GeneralController = function(dependencies = {}) {
    const { httpServiceAyax } = dependencies;
    this.httpServiceAyax = httpServiceAyax;
    this.onInit();
    this.loadAddEvenListener();
    console.log('Controlador general');
};

GeneralController.prototype = Object.create(
    {},
    {
        onInit: {
            value: function() {
                this.gui = this.loadDomElements();
            },
        },

        loadDomElements: {
            value: () => ({
                deleteTextForm: window.document.querySelectorAll('.deleteForm'),
            }),
        },

        loadAddEvenListener: {
            value: function() {
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
    },
);
