import useLocalStorage from "@/composables/useLocalStorage";

const useShoppingCart = () => {
  const { updateStorage, getStorage } = useLocalStorage();

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
