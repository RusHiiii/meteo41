import { useMemo, useState } from 'react';
import { useSelector } from 'react-redux';
import { ROLE_ADMIN } from '../../../constant';

export const userIsAdmin = () => {
  const state = useSelector((state) => state);

  return useMemo(() => {
    return state.user.roles.includes(ROLE_ADMIN);
  }, [state.user.roles]);
};
