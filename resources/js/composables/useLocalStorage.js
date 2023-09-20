const useLocalStorage = () => {
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

  const getStorage = (key) => {
    return JSON.parse(localStorage.getItem(key));
  };

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
