import { useEffect } from 'react';
import {useHistory, withRouter} from 'react-router-dom';

export default function ScrollToTop() {
  const history = useHistory();

  useEffect(() => {
    const unlisten = history.listen(() => {
      window.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    });
    return () => {
      unlisten();
    }
  }, []);

  return null;
}