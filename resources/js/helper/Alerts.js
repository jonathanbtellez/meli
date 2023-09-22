import Swal from "sweetalert2";

/**
 * Show an message and handler the info of this
 * @param {object} error
 * @returns objects with the service errors
 */
export const handlerErrors = async (error) => {
  console.error(error);
  const status = error.response.status;
  let options = null;
  let error_object = {};

  switch (status) {
    case 422:
      {
        options = {
          icon: "error",
          title: "Error: wrong fields.",
          text: "Please complete the form correctly.",
        };
        const errors = error.response.data.errors;
        for (let prop in errors) {
          error_object[prop] = errors[prop][0];
        }
      }
      break;
    case 404:
      options = {
        icon: "error",
        title: "Error: Not found.",
        text: "Please try with other url.",
      };
      break;
    case 403:
      options = {
        icon: "error",
        title: "Error: Unauthorize.",
        text: "You don't have permission to do that.",
      };
      break;
    default:
      options = {
        icon: "error",
        title: "Something went wrong",
        text: "Ops, internal errors please wait.",
      };
      break;
  }
  await Swal.fire(options);
  return error_object;
};

/**
 * Show a custom success message to the user
 * @param {object}
 */
export const successMessage = async ({ is_delete = false, reload = false }) => {
  await Swal.fire({
    icon: "success",
    title: "Success!",
    text: is_delete ? "Info delete correctly." : "Info sava correctly.",
  });
  if (reload) window.location.reload();
};

/**
 * Show a confirm message that return a bolean with the response
 */
export const deleteMessage = async () => {
  const { isConfirmed } = await Swal.fire({
    icon: "warning",
    title: "Are you sure that you want to delete that?",
    showCancelButton: true,
  });
  return isConfirmed;
};
