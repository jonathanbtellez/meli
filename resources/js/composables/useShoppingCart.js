import useLocalStorage from "@/composables/useLocalStorage";

const useShoppingCart = () => {
  const { updateStorage, getStorage } = useLocalStorage();

  /**
   * Check is the product exist if not create a new register, if the product exist add one unit more and finally
   * update the storage
   * @param {number} product_id
   * @param {number} user_id
   */
  const add_product = (product_id, user_id) => {
    const list_added = getStorage("car");

    if (!list_added) {
      updateStorage("car", [{ user_id, product_id, quantity: 1 }]);
      return;
    }
    const added = list_added.find(
      (product) => product.product_id === product_id
    );

    if (!added) {
      updateStorage("car", [
        ...list_added,
        { user_id, product_id, quantity: 1 },
      ]);
      return;
    }

    const list_updated = list_added.map((product) => {
      if (product.product_id === added.product_id) {
        product.quantity++;
      }
      return product;
    });

    updateStorage("car", list_updated);
  };

  /**
   * Delete one unit of the product selected and finally
   * update the storage
   * @param {number} product_id
   * @param {number} user_id
   */
  const remove_product = (product_id) => {
    const list_added = getStorage("car");

    const item = list_added.find(
      (product) => product.product_id === product_id
    );

    const list_updated = list_added.map((product) => {
      if (product.product_id === item.product_id) {
        if (product.quantity === 0) return product;
        product.quantity--;
      }
      return product;
    });

    updateStorage("car", list_updated);
  };

  /**
   * Delete the item selected of the storage
   * @param {number} product_id
   */
  const delete_item = (product_id) => {
    const list_added = getStorage("car");

    const item = list_added.find(
      (product) => product.product_id === product_id
    );

    const list_updated = list_added.filter(
      (product) => product.product_id !== product_id
    );

    updateStorage("car", list_updated);
  };

  return {
    add_product,
    remove_product,
    delete_item,
  };
};

export default useShoppingCart;
