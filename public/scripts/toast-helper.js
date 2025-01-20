const toastFailRequest = function (err) {
  $.toast({
    text:
      err.responseJSON.message ??
      "Failed to fetch data, please try again later.",
    position: "bottom-right",
    bgColor: "#b21313",
    loader: false,
  });
};

toastSuccessRequest = function () {
  $.toast({
    text: "Success fetch data.",
    position: "bottom-right",
    bgColor: "#4bb543",
    loader: false,
  });
};
