import { ref } from "vue";

export default function handlerModal() {
  const modal = ref(null);
  const load_modal = ref(false);

  /**
   * Mount a modal component
   * @param {boolean} status
   * @returns a promise resolve
   */
  const mountedModal = async (status = true) => {
    return await new Promise((resolve, reject) => {
      load_modal.value = status;
      setTimeout(() => resolve(), 200);
    });
  };

  /**
   * Received a id where the modal going to be charged
   * and the open the modal
   * @param {string} modal_id
   */
  const openModal = async (modal_id) => {
    await mountedModal();
    modal.value = new bootstrap.Modal(`#${modal_id}`);
    modal.value.show();
  };

  /**
   * Close the modal component and unmount it
   */
  const closeModal = async () => {
    modal.value.hide();
    await mountedModal(false);
  };

  return {
    load_modal,
    closeModal,
    openModal,
  };
}
