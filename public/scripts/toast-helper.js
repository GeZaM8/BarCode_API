const toastFailRequest = function (
  err = "Failed to fetch data, please try again later."
) {
  $.toast({
    text: err.responseJSON.message,
    position: "bottom-right",
    bgColor: "#b21313",
    loader: false,
  });
};

const toastSuccessRequest = function (msg = "Success fetch data.") {
  $.toast({
    text: msg,
    position: "bottom-right",
    bgColor: "#4bb543",
    loader: false,
  });
};
