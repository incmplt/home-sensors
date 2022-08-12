# -*- coding: utf-8 -*-

# Home Sensors Configuration
SENSOR_LOG="/tmp/sensor.log"

# SENSOR_POS
# 0 : indoor sensor
# 1 : outdoors sensor
SENSOR_POS=0

# ENABLE_CO2
#  0 : Disable Co2/MH-Z19 Sensor
#  1 : Enable Co2/MH-Z19 Sensor
ENABLE_CO2=1

# Optional : Azure Iot Relation
ENABLE_AZURE=0

# Optional :  SensorDB Configuration
ENABLE_DB=1
# SENSOR_PROTOCOL : HTTP or HTTPS
SENSOR_PROTOCOL="HTTP"
# SENSOR_SERVER : IP address or FQDN
SENSOR_SERVER="192.168.1.140"
# SENSOR_ENDPOINT : API path
#SENSOR_ENDPOINT="/api/v1/post"
SENSOR_ENDPOINT="/api/postSensor.php"

# Optional : Google Home
HOMENAME="GoogleHomeOffice"

WBGT_WRN=28.0
WBGT_CLT=31.0

TMPL_WRN=30.0
TMPL_CLT=33.0

LANG="ja"
PERIOD=60

WBGT_WRN_MSG="暑さ指数 警戒 : 熱中症に注意してください"
WBGT_CLT_MSG="暑さ指数 危険 : 今すぐ涼しい環境に移動してください"

TMPL_WRN_MSG="温度上昇 : クーラーを使用してください"
TMPL_CLT_MSG="温度危険 : 今すぐ涼しい場所に退避してください"

if __name__ == "__main__":
  print( "Home Sensors Configuration file.")
