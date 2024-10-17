console.log("enviar datos !!!!!!")
var hostname = "driver.cloudmqtt.com";
var port = 38946;
var clientId = "webio4mqttexample";
clientId += new Date().getUTCMilliseconds();;
var username = "ewdpapwh";
var password = "7vv-d_G6tbWC";


mqttClient = new Paho.MQTT.Client(hostname, port, clientId);
mqttClient.onMessageArrived = MessageArrived;
mqttClient.onConnectionLost = ConnectionLost;
Connect();

function Connect() {
	mqttClient.connect({
		onSuccess: Connected,
		onFailure: Conexionfallida,
		keepAliveInterval: 10,
		userName: username,
		useSSL: true,
		password: password
	});
}

function Connected() {
	console.log("Connected");
	mqttClient.subscribe("apellidos/temp");
}

function Conexionfallida(res) {
	console.log("Connect failed:" + res.errorMessage);
}

function ConnectionLost(res) {
	if (res.errorCode != 0) {
		console.log("Connection lost:" + res.errorMessage);
		Connect();
	}
}

function MessageArrived(message) {
	console.log(message.destinationName + " : " + message.payloadString);
	if (message.destinationName === "apellidos/temp") {
		a.refresh(message.payloadString);
		valor_temp = parseFloat(message.payloadString);
	}
	


}