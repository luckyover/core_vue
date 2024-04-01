IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M101_INQ3]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M101_INQ3
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M101_INQ3 '0001', '0', '20','809','M101','172.19.0.1';
--****************************************************************************************	
--*   											
--*  処理概要/process overview	:	Get list data product for suggest search
--*  
--*  作成日/create date			:	2024/02/25
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M101_INQ3
	@P_search						NVARCHAR(MAX)   = N''
,	@P_item_class_div				INT				= 0
,	@P_rows							INT				= 20
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	SELECT TOP (@P_rows)
		M101.item_cd					AS code
	,   M101.item_nm					AS [name]
	,	IIF(
			ISNULL(M101.color_cd, '')	<> ''
		OR	ISNULL(M101.color_nm, '')	<> ''
		,	M101.color_cd +
			IIF(
				ISNULL(M101.color_cd, '') <> ''
			AND ISNULL(M101.color_nm, '') <> ''
			,	':'
			,	''
			) + M101.color_nm
		,	''
		)								AS subTitle
	,	M101.color_cd					AS value1
	,	M101.color_nm					AS value2
	FROM M101 WITH(NOLOCK)
	WHERE (
		@P_search						= ''
	OR	M101.item_nm					LIKE '%' + @P_search + '%'
	OR	M101.item_kn_nm					LIKE '%' + @P_search + '%'
	OR	M101.item_ab_nm					LIKE '%' + @P_search + '%'
	OR	CONVERT(NVARCHAR, M101.item_cd) LIKE '%' + @P_search + '%'
	)
	AND (
		@P_item_class_div				= 0
	OR	(
			@P_item_class_div			= -1
		AND  M101.item_class_div		<> 2
	)
	OR  M101.item_class_div				= @P_item_class_div
	)
	AND M101.del_flg					<> 1
END
GO
