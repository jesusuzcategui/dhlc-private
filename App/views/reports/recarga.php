<?php
$html = '<!doctype html>
                                <html>
                                <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                    <title>Factura sistema locutorios</title>

                                </head>
                                <body>
                                    <table style="width: 600px;margin: 0 auto;background: #f3f3f3;border: solid 1px rgba(212, 212, 212, 0.5);font-family: sans-serif;font-weight: normal;
    border-collapse: collapse;">
		                                <tr>
                                			<td style="text-align: center;
                                    padding: 15px 0;
                                    background: #13152d;">
<img style="width: 180px; object-fit:contain;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAPoAAABaCAYAAACR8EvTAAABN2lDQ1BBZG9iZSBSR0IgKDE5OTgpAAAokZWPv0rDUBSHvxtFxaFWCOLgcCdRUGzVwYxJW4ogWKtDkq1JQ5ViEm6uf/oQjm4dXNx9AidHwUHxCXwDxamDQ4QMBYvf9J3fORzOAaNi152GUYbzWKt205Gu58vZF2aYAoBOmKV2q3UAECdxxBjf7wiA10277jTG+38yH6ZKAyNguxtlIYgK0L/SqQYxBMygn2oQD4CpTto1EE9AqZf7G1AKcv8ASsr1fBBfgNlzPR+MOcAMcl8BTB1da4Bakg7UWe9Uy6plWdLuJkEkjweZjs4zuR+HiUoT1dFRF8jvA2AxH2w3HblWtay99X/+PRHX82Vun0cIQCw9F1lBeKEuf1UYO5PrYsdwGQ7vYXpUZLs3cLcBC7dFtlqF8hY8Dn8AwMZP/fNTP8gAAAAJcEhZcwAAJOkAACTpAVAk5/gAAAdqaVRYdFhNTDpjb20uYWRvYmUueG1wAAAAAAA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzE0MiA3OS4xNjA5MjQsIDIwMTcvMDcvMTMtMDE6MDY6MzkgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ0MgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxOS0wOS0xNVQxMDoxNTo0OC0wNTowMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAxOS0wOS0xNVQxMDoxNTo0OC0wNTowMCIgeG1wOk1vZGlmeURhdGU9IjIwMTktMDktMTVUMTA6MTU6NDgtMDU6MDAiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6YTI3MmY4NGMtMTcyYi02MjQ5LTkyMmEtYzM1YzU4M2Y4YTVjIiB4bXBNTTpEb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6MDg2ODRkMDAtZTE5YS04MzQyLTk3ZGEtNGNmMGZjZjZmM2ExIiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InhtcC5kaWQ6YTY0NzA5M2QtMjg2OC1lNDQ0LTkyMTMtZmVkZTE3ZjljNDNhIiBkYzpmb3JtYXQ9ImltYWdlL3BuZyIgcGhvdG9zaG9wOkNvbG9yTW9kZT0iMyIgcGhvdG9zaG9wOklDQ1Byb2ZpbGU9IkFkb2JlIFJHQiAoMTk5OCkiPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjcmVhdGVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmE2NDcwOTNkLTI4NjgtZTQ0NC05MjEzLWZlZGUxN2Y5YzQzYSIgc3RFdnQ6d2hlbj0iMjAxOS0wOS0xNVQxMDoxNTo0OC0wNTowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6YTI3MmY4NGMtMTcyYi02MjQ5LTkyMmEtYzM1YzU4M2Y4YTVjIiBzdEV2dDp3aGVuPSIyMDE5LTA5LTE1VDEwOjE1OjQ4LTA1OjAwIiBz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">
                                			</td>
		                                </tr>
		                                <tr>
			                                <td><h2 style="text-align: center;font-weight: 100;color: #797979;">DETALLE DE COMPRA</h2></td>
			                            </tr>
			                            <tr>
    			                            <td>
    			                                <p style="text-align: justify;word-wrap: break-word;padding: 0 15px;line-height: 1.8;font-size: 15px;
    font-weight: 300;text-indent: 1cm;">
                                                    Hola, nos complace informarle que la compra del PIN de recarga para seguir disfrutando de nuestros servicios, ha sido exitosa. Asi mismo, en este correo dejaremos los detalles de la misma incluyendo el PIN que adquirio.</p>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width: 100%;
    border-collapse: collapse;
    background: #3c3c3c;">
					<tr style="    height: 50px;
    text-align: center;
    font-weight: 100;
    font-size: small;
    color: white;">
						<th style="border: solid 1px rgba(255,255,255,.2)">
							COD. COMPRA
						</th>
						<th style="border: solid 1px rgba(255,255,255,.2)">
							PIN DE RECARGA
						</th>
						<th style="border: solid 1px rgba(255,255,255,.2)">
							MONTO CLP
						</th>
					</tr>
					<tr style="    color: white;
          $monto =
    text-align: center;">
						<td style="border: solid 1px rgba(255,255,255,.2)">
						'.$_SESSION["ventaid"].'
						</td>
						<td style="border: solid 1px rgba(255,255,255,.2)">
						 '.$_SESSION['compra_tarjeta'].'
						</td>
						<td style="border: solid 1px rgba(255,255,255,.2)">
							CLP '.$_SESSION['compra_monto'].'$
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width: 100%;
    border-collapse: collapse;
    background: #484848;">
					<tr style="    height: 40px;
    text-align: center;
    font-weight: 100;
    font-size: small;
    color: white;">
						<td>
							<p>LOCUTORIOS &copy; - 2020</p>
							<p>Para cualquier informacion, no dude comunicarse a traves de nuestros siguientes medios</p>
							<p>
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	</body>
	</html>';
return $html;
