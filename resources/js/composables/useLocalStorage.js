const useLocalStorage = () => {
  /**Check if exist a storage of the key given is not exist create the storage,
   * if exist update it
   *
   * @param {string} key
   * @param {Object} value
   */
  const updateStorage = (key, value) => {
    if (!key) {
      return;
    }
    const store = localStorage.getItem(key);
    if (!store) {
      localStorage.setItem(key, JSON.stringify(value));
    } else {
      localStorage.setItem(key, JSON.stringify(value));
    }
  };

  /**
   *
   * @param {String} key
   * @returns Return the storage related to the key is not exist return undefined
   */
  const getStorage = (key) => {
    return JSON.parse(localStorage.getItem(key));
  };

  /**
   * Delete the storage related to the key
   * @param {String} key
   */
  const removeStorage = (key) => {
    localStorage.removeItem(key);
  };

  return {
    updateStorage,
    getStorage,
    removeStorage,
  };
};

export default useLocalStorage;
