import { useToast as usePluginToast } from "vue-toast-notification";

const useToast = () => {
  const $toast = usePluginToast();

  /**
   * Open a toast message with the info of the params given
   * @param {string} message
   * @param {string} type
   */
  const openToast = (message, type) => {
    $toast.open({
      message,
      position: "top-right",
      type,
      duration: 1500,
      dismissible: true,
    });
  };

  /**
   * Open a toast message with the info of the params given
   * When the toast disappear execute the callback onDismiss
   * @param {string} message
   * @param {string} type
   * @param {callback} onDismiss
   */
  const openFunctionToast = (message, type, onDismiss) => {
    $toast.open({
      message,
      position: "top-right",
      type,
      duration: 1500,
      dismissible: true,
      onDismiss,
    });
  };

  return {
    openToast,
    openFunctionToast,
  };
};

export default useToast;
