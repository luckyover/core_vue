IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M005_INQ3]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M005_INQ3
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M005_INQ3 '53','20','809','M101','172.19.0.1';
--****************************************************************************************	
--*   											
--*  �����T�v/process overview	:	Get list data delivery for suggest search
--*  
--*  �쐬��/create date			:	2024/02/27
--*�@�쐬��/creater				:	QuyPN - ANS809
--*   					
--*  �X�V��/update date			:   
--*�@�X�V��/updater				:   
--*�@�X�V���e/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M005_INQ3
	@P_search						NVARCHAR(MAX)   = N''
,	@P_rows							INT				= 20
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	SELECT TOP (@P_rows)
		M005.delivery_cd				AS code
	,   M005.delivery_nm				AS [name]
	,	M005.delivery_kn_nm				AS subTitle
	FROM M005 WITH(NOLOCK)
	WHERE (
		@P_search						= ''
	OR	M005.delivery_nm				LIKE '%' + @P_search + '%'
	OR	M005.delivery_kn_nm				LIKE '%' + @P_search + '%'
	OR	M005.delivery_ab_nm				LIKE '%' + @P_search + '%'
	OR	CONVERT(NVARCHAR, M005.delivery_cd) LIKE '%' + @P_search + '%'
	)
	AND M005.del_flg					<> 1
END
GO
