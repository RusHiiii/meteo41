import { useEffect } from 'react';
import {useHistory, withRouter} from 'react-router-dom';

export default function ScrollToTop() {
  const history = useHistory();

  useEffect(() => {
    const unlisten = history.listen(() => {
      window.scrollTo(0, 0);
    });
    return () => {
      unlisten();
    }
  }, []);

  return null;
}