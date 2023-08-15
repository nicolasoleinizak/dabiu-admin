export const fetchStatusToAlertType = (status) => {
  const alertType = {
    loading: 'info',
    success: 'success',
    error: 'error',
    notFound: 'warning'
  };
  return alertType[status];
}