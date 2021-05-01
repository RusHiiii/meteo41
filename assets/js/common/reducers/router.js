export const ROUTER_CHANGE = 'ROUTER_CHANGE';

const initialState = {
  location: null,
  name: null,
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case ROUTER_CHANGE:
      return {
        location: action.location,
        name: action.name,
      };
  }

  return state;
}
