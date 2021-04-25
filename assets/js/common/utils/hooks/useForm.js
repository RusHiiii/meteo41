import { useState } from 'react';

export const useForm = (callback, initialValue) => {
  const [inputs, setInputs] = useState(() => {
    let inputs = {};

    for (const [key, value] of Object.entries(initialValue)) {
      inputs[key] = value;
    }

    return inputs;
  });

  const handleSubmit = (event) => {
    if (event) {
      event.preventDefault();
      callback(inputs);
    }
  };

  const handleInputChange = (value, name) => {
    setInputs((inputs) => ({
      ...inputs,
      [name]: value,
    }));
  };

  const reset = () => {
    setInputs((inputs) => ({}));
  };

  return {
    handleSubmit,
    handleInputChange,
    reset,
    inputs,
  };
};
