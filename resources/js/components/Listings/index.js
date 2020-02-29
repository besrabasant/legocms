import RowActionEdit from "./RowActionEdit";
import RowActionDelete from "./RowActionDelete";
import DeleteConfirmationModal from "./DeleteConfirmationModal";
import ResourceActionCreate from "./ResourceActionCreate";

export default {
    init() {
        var $rootEL = document.getElementById("listings-root");

        if ($rootEL != null) {
            return new Vue({
                name: "legoCMS-listings",
                el: $rootEL,
                components: {
                    'legocms-row-action-edit': RowActionEdit,
                    'legocms-row-action-delete': RowActionDelete,
                    'legocms-row-action-destroy': RowActionDelete,
                    'legocms-delete-confirm': DeleteConfirmationModal,
                    'legocms-resource-action-create': ResourceActionCreate
                }
            });
        }

        return false;
    }
}