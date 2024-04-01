IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M005_INQ1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M005_INQ1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M005_INQ1 '00001','','Swagger','172.18.0.1'; 
--****************************************************************************************
--*  											
--*  処理概要/process overview	:	Get detail of delivery
--*  
--*  作成日/create date			:	2024/02/19
--*　作成者/creater				:	QuanLH - ANS902
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M005_INQ1
	@P_delivery_cd					INT				= 0
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	SELECT TOP 1
		M005.delivery_cd
	,	M005.delivery_nm				
	,	M005.delivery_kn_nm			
	,	M005.delivery_ab_nm			
	,	M005.delivery_zip			
	,	M005.delivery_address1		
	,	M005.delivery_address2		
	,	M005.delivery_address3		
	,	M005.delivery_tel			
	,	M005.delivery_fax			
	,	M005.delivery_department_nm	
	,	M005.delivery_manager_nm		
	,	M005.delivery_mail_address	
	,	M005.remarks					
	,	M005.cre_user_cd
	,	cre_user.user_nm						AS cre_user_nm
	,	FORMAT(M005.cre_tm, 'yyyy/MM/dd HH:mm')	AS cre_tm
	,	M005.upd_user_cd
	,	upd_user.user_nm						AS upd_user_nm
	,	FORMAT(M005.upd_tm, 'yyyy/MM/dd HH:mm')	AS upd_tm
	FROM M005 WITH(NOLOCK)
	LEFT JOIN M002		AS	cre_user WITH(NOLOCK)	ON (
		M005.cre_user_cd				= cre_user.user_cd
	)
	LEFT JOIN M002		AS	upd_user WITH(NOLOCK)	ON (
		M005.upd_user_cd				= upd_user.user_cd
	)
	WHERE
		M005.delivery_cd				= @P_delivery_cd
	AND M005.del_flg					<> 1
END
GO
