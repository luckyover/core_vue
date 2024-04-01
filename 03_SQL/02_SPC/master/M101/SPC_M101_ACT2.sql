IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M101_ACT2]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M101_ACT2
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M101_ACT2 'ITEM1','','809','M101','172.19.0.1';
--****************************************************************************************
--* 											
--*  処理概要/process overview	:	Delete a product
--*  
--*  作成日/create date			:	2024/02/22
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M101_ACT2
	@P_item_cd						NVARCHAR(30)	= N''
,	@P_color_cd						NVARCHAR(10)	= N''
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
	-- variable general
		@w_time						DATETIME2		=	SYSDATETIME()
	,	@ERR_TBL					ERRTABLE
	-- variable log
    ,   @w_prs_mode					NVARCHAR(200)   =   N'Delete'
    ,   @w_prs_result				NVARCHAR(200)   =   N'OK'
	,	@w_remarks					NVARCHAR(200)	=	N''
	,	@w_table_key				NVARCHAR(200)	=	N'item_cd=' + @P_item_cd + ';color_cd=' + @P_color_cd
	SET @P_color_cd = ISNULL(@P_color_cd, N'')
	-- START TRANSACTION 
	BEGIN TRANSACTION
	-- TRY CATCH EXCEPTION
	BEGIN TRY
		UPDATE M101 SET
			del_user_cd				= @P_act_user_cd
		,	del_prg					= @P_prg
		,	del_ip					= @P_ip
		,	del_tm					= @w_time
		,	del_flg					= 1
		WHERE
			item_cd					= @P_item_cd
		AND color_cd				= @P_color_cd

		UPDATE M102 SET
			del_user_cd				= @P_act_user_cd
		,	del_prg					= @P_prg
		,	del_ip					= @P_ip
		,	del_tm					= @w_time
		,	del_flg					= 1
		WHERE
			item_cd					= @P_item_cd
		AND color_cd				= @P_color_cd

		UPDATE M201 SET
			del_user_cd				= @P_act_user_cd
		,	del_prg					= @P_prg
		,	del_ip					= @P_ip
		,	del_tm					= @w_time
		,	del_flg					= 1
		WHERE
			item_cd					= @P_item_cd
		AND color_cd				= @P_color_cd

		UPDATE M202 SET
			del_user_cd				= @P_act_user_cd
		,	del_prg					= @P_prg
		,	del_ip					= @P_ip
		,	del_tm					= @w_time
		,	del_flg					= 1
		WHERE
			item_cd					= @P_item_cd
		AND color_cd				= @P_color_cd
	END TRY
	BEGIN CATCH
		SET @w_prs_result	=	'NG'
		SET @w_remarks		=	N'Error'                                                           + CHAR(13) + CHAR(10) +
								N'Procedure : ' + ISNULL(ERROR_PROCEDURE(), N'???')                + CHAR(13) + CHAR(10) +
								N'Line : '      + ISNULL(CAST(ERROR_LINE() AS NVARCHAR(10)), N'0') + CHAR(13) + CHAR(10) +
								N'Message : '   + ISNULL(ERROR_MESSAGE(), N'An unexpected error occurred.')
        DELETE FROM @ERR_TBL
        INSERT INTO @ERR_TBL
        SELECT  
            N'E009'
        ,   N''
        ,   0
        ,   999
        ,   0
		,	N''
        ,   @w_remarks
	END CATCH
    IF EXISTS (SELECT 1 FROM @ERR_TBL)
	BEGIN
		IF(@@TRANCOUNT > 0)
        BEGIN
            ROLLBACK TRANSACTION
        END
	END
	ELSE
	BEGIN
		DELETE FROM @ERR_TBL
		IF(@@TRANCOUNT > 0)
        BEGIN
            COMMIT TRANSACTION
        END
	END
    -- Insert statements for procedure here
	COMPLETE_QUERY:

	EXEC SPC_S999_ACT1
		@P_act_user_cd
	,	@P_prg
	,	@w_prs_mode
	,	@w_table_key
	,	@w_prs_result
	,	@w_remarks

	SELECT * FROM @ERR_TBL

END
GO
