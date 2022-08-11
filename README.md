# Home sensor on RaspberryPi 3/4

このプロジェクトは、RaspberryPi に簡易的なセンサーを追加して自宅のコンディションを監視する目的で作成したコード群である。

## Description

本ソースコードのハードウェア準備については、以下のWEBページを参照。

Reference: [RaspberryPi Sensors : incmplt Site](https://www.incmplt.net/2021/06/27/raspberrypi-sensors/)

## Requirement

本環境は、以下のハードウェアで構成している。

* RaspberryPi 3B or 4
* BME280
* MH-Z19
* python3
* Network Connection
* Option: Google Home

![Home Sensors](/doc/RaspberryPi-HomeSensors.png)

RaspberryPi ZARO(WH) では、MH-Z19 の Co2 取得が上手くいかない場合があった。
推奨は、RaspberryPi 3 もしくは 4 とする。

また、ネットワークの通信は wlan0 を想定してスクリプトを作成している。
サーバーの通知機能を wlan0 以外で使用する場合には、スクリプトの値を変更する必要がある。

## Usage

センサーの値を取得してログファイルに記録するには、以下のコマンドを実行する。

```bash
sudo python3 /opt/iot/bin/saveSensors.py
```

取得した値が、以下のように記録される。

```text
# tail /tmp/sensor.log
2022/08/09 05:30:02,29.4,75.04,997.7,573.0,28.86
2022/08/09 06:00:02,29.36,75.6,997.8,569.0,28.9
2022/08/09 06:30:02,29.37,72.95,997.7,580.0,28.53
2022/08/09 07:00:02,29.4,73.22,997.6,584.0,28.6
2022/08/09 07:30:02,29.58,73.71,997.6,514.0,28.85
2022/08/09 08:00:02,29.87,72.81,997.5,461.0,29.01
2022/08/09 08:30:02,29.89,73.64,997.4,461.0,29.15
2022/08/09 09:00:02,30.32,71.62,997.4,442.0,29.28
2022/08/09 09:30:02,30.62,71.44,997.4,445.0,29.54
2022/08/09 10:00:01,31.74,63.97,997.6,431.0,29.51
```

定期的に値を取得するには、以下のように cron に設定を追加する。

```cron
*/30 * * * * sudo python3 /opt/iot/bin/saveSensor.py
```

## Install

RaspberryPi の シリアルポートを使用するため、Raspi-configでシリアルポートを有効にしておく。

```bash
sudo raspi-config
```

* 3 Interface Options
* P6 Serial Port

以下のパッケージを準備する。

```bash
sudo apt install python3
sudo apt install i2c-tools
sudo pip3 install mh-z19
```

i2c-tools をインストールしたら、Linux Industrial I/O Subsystem (Linux IIO) を使用できるようにするために、/boot/config.txt に以下の行を追加する。

```text
dtoverlay=i2c-sensor,bme280
```

設定を追加したら有効にするために再起動する。
再起動後に以下のコマンドを実行し BME280 を認識しているかを確認する。

```bash
pi@raspberrypi:~ $ cat /sys/bus/iio/devices/iio\:device0/name
bme280
```

環境の構築は make コマンドを使用する。

```bash
make install
```

## Optional

現在の開発コードには、以下の機能を追加している。

* リモートサーバーの MySQL データベースに記録
* 温度と暑さ指数が閾値を越えたら Google Home で音声で警告
* Azure IoT Hub を使用して データを記録(データ期間を考えると優先度低い)

## Licence

[MIT](https://github.com/tcnksm/tool/blob/master/LICENCE)

## Author

* [incmplt](https://www.incmplt.net/)
* [Info Circus,Inc.](https://www.infocircus.jp/)
